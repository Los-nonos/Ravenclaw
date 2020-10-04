<?php


namespace Infrastructure\Payments;


use Domain\Entities\Payment;
use Domain\Enums\PaymentState;
use Domain\ValueObjects\PaymentRejectedError;
use Exception;
use Infrastructure\Payments\DecidirSdk\Decidir;
use Infrastructure\Payments\Exceptions\PaymentRejectedException;
use Infrastructure\Payments\Interfaces\AuthorizableGateway;
use Infrastructure\Payments\Interfaces\PaymentGateway;
use Infrastructure\Payments\ValueObjects\PaymentParams;

class DecidirGateway implements PaymentGateway, AuthorizableGateway
{
  const KEY_CARD_NUMBER = 'bin';
  const KEY_CARD_EXPIRATION_MONTH = 'expiration_month';
  const KEY_CARD_EXPIRATION_YEAR = 'expiration_year';
  const KEY_SECURITY_CODE = 'secure_code';
  const KEY_CARD_HOLDER_NAME = 'name';
  const KEY_CARD_HOLDER_IDENTIFICATION = 'identification';
  private Decidir $decidir;

  public function __construct(
    Decidir $decidir
  ) {
    $this->decidir = $decidir;
  }

  const KEY_TOKEN = 'token';
  const KEY_BIN = 'bin';
  const KEY_INSTALLMENTS = 'installments';
  const KEY_CUSTOMER_ID = 'customer_id';
  const KEY_CUSTOMER_EMAIL = 'email';
  const KEY_PAYMENT_METHOD_ID = 'payment_method_id';
  const ERROR_INVALID_REQUEST = 'invalid_request_error';
  const SELF_ERROR_MESSAGE = 'Verificar los datos ingresados';

  public function prepare(Payment $payment, PaymentParams $paymentParams = null): Payment
  {
    logger('Preparing payment for Decidir Gateway #' . $payment->getId());

    $paymentData = [
      "site_transaction_id" => uniqid() . '-' . $payment->getId(),
      "customer" => [
        'id' => $paymentParams->getParam(self::KEY_CUSTOMER_ID)
      ],
      "token" => $paymentParams->getParam(self::KEY_TOKEN),
      "payment_method_id" => intval($paymentParams->getParam(self::KEY_PAYMENT_METHOD_ID)),
      "bin" => $paymentParams->getParam(self::KEY_BIN),
      "amount" => intval($payment->getTransactionAmount()->getAmount()),
      "currency" => $payment->getTransactionAmount()->getCurrency()->getSymbol(),
      "installments" => intval($paymentParams->getParam(self::KEY_INSTALLMENTS)),
      "description" => $payment->getDescription(),
      "payment_type" => "single",
      "sub_payments" => []
    ];

    logger('Request data: ' . print_r($paymentData, true));
    $payment->setRequestData($paymentData);
    return $payment;
  }

  public function process(Payment $payment): Payment
  {
    logger('Attempting to process payment # ' . $payment->getId());

    $response = $this->decidir->process($payment->getRequestData(), $payment->getParams());
    logger('Received response', $response);

    if (!isset($response['payload']) || !isset($response['payload']['id'])) {
      logger('Unexpected response' . json_encode($response));
      //throw new Exception('Unexpected response');
    }

    if (isset($response['payload']) && isset($response['payload']['error_type'])) {
      $error = $response['payload']['error_type'];

      if ($error === self::ERROR_INVALID_REQUEST) {

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

  public function authorize(PaymentParams $paymentParams)
  {
    $paymentData = [
      'card_number' => $paymentParams->getParam(self::KEY_CARD_NUMBER),
      'card_expiration_month' => $paymentParams->getParam(self::KEY_CARD_EXPIRATION_MONTH),
      'card_expiration_year' => $paymentParams->getParam(self::KEY_CARD_EXPIRATION_YEAR),
      'security_code' => $paymentParams->getParam(self::KEY_SECURITY_CODE),
      'card_holder_name' => $paymentParams->getParam(self::KEY_CARD_HOLDER_NAME),
      'card_holder_identification' => [
        'type' => 'dni',
        'number' => $paymentParams->getParam(self::KEY_CARD_HOLDER_IDENTIFICATION),
      ]
    ];

    $response = $this->decidir->authorize($paymentData);

    if (isset($response['payload'])) {
      return [
        'bin' => $response['payload']['bin'],
        'token' => $response['payload']['id']
      ];
    }

    throw new PaymentRejectedException();
  }
}
