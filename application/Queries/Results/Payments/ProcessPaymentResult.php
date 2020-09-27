<?php


namespace Application\Queries\Results\Payments;


use Domain\ValueObjects\Payment;
use Infrastructure\QueryBus\Result\ResultInterface;

class ProcessPaymentResult implements ResultInterface
{
    private Payment $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }
}
