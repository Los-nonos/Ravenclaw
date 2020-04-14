<?php


namespace Application\Results\Payments;


use Domain\Entities\Payment;

class PaypalAuthorizationResult implements PaypalAuthorizationResultInterface
{
    private Payment $payment;

    public function setPayment(Payment $payment): void
    {
        $this->payment = $payment;
    }

    public function getPayment(): Payment
    {
        return $this->payment;
    }
}
