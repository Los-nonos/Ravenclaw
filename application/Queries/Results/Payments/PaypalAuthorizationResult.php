<?php


namespace Application\Queries\Results\Payments;


use Domain\Entities\Payment;
use Infrastructure\QueryBus\Result\ResultInterface;

class PaypalAuthorizationResult implements ResultInterface
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
