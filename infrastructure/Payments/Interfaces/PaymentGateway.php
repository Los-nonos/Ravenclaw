<?php


namespace Infrastructure\Payments\Interfaces;


use Domain\ValueObjects\Payment;

interface PaymentGateway
{
    public function process(Payment $payment): Payment;
}
