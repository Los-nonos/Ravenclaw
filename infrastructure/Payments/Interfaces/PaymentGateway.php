<?php


namespace Infrastructure\Payments\Interfaces;


use Domain\Entities\Payment;
use Infrastructure\Payments\ValueObjects\PaymentParams;

interface PaymentGateway
{
  public function prepare(Payment $payment, PaymentParams $params): Payment;
  public function process(Payment $payment): Payment;
  public function currentState(Payment $payment): string;
}
