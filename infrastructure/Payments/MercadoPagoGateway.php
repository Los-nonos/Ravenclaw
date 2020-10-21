<?php


namespace Infrastructure\Payments;


use Domain\Enums\PaymentState;
use Domain\Entities\Payment;
use Domain\ValueObjects\PaymentRejectedError;
use Exception;
use Infrastructure\Payments\Exceptions\PaymentRejectedException;
use Infrastructure\Payments\Interfaces\PaymentGateway;
use Infrastructure\Payments\MercadoPagoSdk\MercadoPago;
use Infrastructure\Payments\ValueObjects\PaymentParams;

class MercadoPagoGateway implements PaymentGateway
{
  const KEY_INSTALLMENTS = 'installments';
  const KEY_TOKEN = 'authorization';
  const SELF_ERROR_MESSAGE = 'Verificar los datos ingresados';
  const PAYMENT_METHOD = 'payment_method';

  private MercadoPago $mercadoPago;

    public function __construct(MercadoPago $mercadoPago)
    {
        $this->mercadoPago = $mercadoPago;
    }

    public function prepare(Payment $payment, PaymentParams $params): Payment
    {
      logger('Preparing payment for MercadoPago Gateway #' . $payment->getId());

      $paymentData = [
          'transaction_amount' => ($payment->getTransactionAmount()->getAmount() / 100),
          'token' => $params->getParam(self::KEY_TOKEN),
          'description' => $payment->getDescription(),
          'payment_method_id' => $params->getParam(self::PAYMENT_METHOD),
          'binary_mode' => true,
          'external_reference' => uniqid() . '-' . $payment->getId(),
          'installments' => intval($params->getParam(self::KEY_INSTALLMENTS)),
          'statement_descriptor' => $payment->getDescription(),
          'payer' => [
              'email' => $payment->getPayer()->getEmail()
          ]
      ];

      logger('Request data: ' . print_r($paymentData, true));
      $payment->setRequestData($paymentData);

      return $payment;
    }

    public function process(Payment $payment): Payment
    {
        logger('Attempting to process payment #' . $payment->getId());

        $response = $this->mercadoPago->process($payment->getRequestData(), $payment->getParams());

        if (isset($response['payload']) && isset($response['payload']['error_type']))
        {
          logger(self::SELF_ERROR_MESSAGE);

          $error = new PaymentRejectedError(
              400,
              $response['payload']['error_type'],
              self::SELF_ERROR_MESSAGE
          );

          $exception = new PaymentRejectedException();
          $exception->setError($error);

          throw $exception;
        }

        $payment->setResponseData($response['payload']);
        $payment->setExternalId($response['payload']['id'] ?? 0);

        return $payment;
    }

    public function currentState(Payment $payment): string
    {
        $data = $payment->getResponseData();

        if (empty($data['status'])) {
            throw new Exception('', 400);
        }

        if ($data['status'] === 'rejected') {
            return PaymentState::REJECT;
        }

        if ($data['status'] === 'approved') {
            return PaymentState::AUTHORIZED;
        }

        return PaymentState::REJECT;
    }
}
