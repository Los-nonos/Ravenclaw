<?php


namespace Infrastructure\Payments;


use Domain\Enums\PaymentState;
use Domain\Enums\State;
use Domain\Entities\Payment;
use Domain\ValueObjects\PaymentRejectedError;
use Exception;
use Infrastructure\Payments\Exceptions\PaymentRejectedException;
use Infrastructure\Payments\Interfaces\PaymentGateway;
use Infrastructure\Payments\PaypalSdk\Paypal;
use Infrastructure\Payments\ValueObjects\PaymentParams;

class PaypalGateway implements PaymentGateway
{

  const SELF_ERROR_MESSAGE = 'Validar los datos ingresados';
  private Paypal $paypal;

  public function __construct(Paypal $paypal)
  {
    $this->paypal = $paypal;
  }

  public function prepare(Payment $payment, PaymentParams $params): Payment
  {
    logger('Preparing payment for Paypal Gateway #' . $payment->getId());

    $paymentData = [
      'intent' => 'capture',
      'purchase_units' => [
        [
          'amount' => [
            'total' => $payment->getTransactionAmount()->getAmount(),
            'currency' => $payment->getTransactionAmount()->getCurrency()->getSymbol(),
          ]
        ]
      ],
      'payer' => [
        'payment_method' => 'paypal'
        //'payment_method' => 'credit_card',
        //'funding_instruments' => [
        //  'number_card' =>
      ],
      'redirect_urls' => [
        'cancel_url' => 'https://example.com/shopping_cart',
        'return_url' => 'https://example.com/thanks',
      ]
    ];

    logger('Request data: ' . print_r($paymentData, true));

    $payment->setRequestData($paymentData);
    return $payment;
  }

  public function process(Payment $payment): Payment
  {
    logger('Attempting to process payment #' . $payment->getId());

    $response = $this->paypal->process($payment->getRequestData(), $payment->getParams());

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
