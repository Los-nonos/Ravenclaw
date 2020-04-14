<?php


namespace Application\Commands\Payments;


class PaypalExecuteCommand
{
    private string $paymentId;
    private string $payerId;

    public function __construct(string $paymentId, string $payerId)
    {
        $this->paymentId = $paymentId;
        $this->payerId = $payerId;
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function getPayerId(): string
    {
        return $this->payerId;
    }
}
