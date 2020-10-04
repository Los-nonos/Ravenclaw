<?php


namespace Infrastructure\Payments;


use Domain\Enums\State;
use Domain\Entities\Payment;
use Exception;
use Infrastructure\Payments\Interfaces\PaymentGateway;
use Infrastructure\Payments\ValueObjects\PaymentParams;

class PaypalGateway implements PaymentGateway
{

    public function __construct()
    {
    }


    public function process(Payment $payment): Payment
    {
        if ($payment->getLastStatus() !== State::AUTHORIZED) {
            throw new Exception("can not process this payment");
        }


        return $payment;
    }

  public function prepare(Payment $payment, PaymentParams $params): Payment
  {
    // TODO: Implement prepare() method.
  }

  public function currentState(Payment $payment): string
  {
    // TODO: Implement currentState() method.
  }
}
