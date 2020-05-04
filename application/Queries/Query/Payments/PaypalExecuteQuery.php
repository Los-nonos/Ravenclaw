<?php


namespace Application\Queries\Query\Payments;


use Infrastructure\QueryBus\Query\QueryInterface;

class PaypalExecuteQuery implements QueryInterface
{
    private string $paymentId;
    private string $payerId;
    private int $customer_id;
    private string $access_token;

    public function __construct(string $paymentId, string $payerId, int $customer_id, string $access_token)
    {
        $this->paymentId = $paymentId;
        $this->payerId = $payerId;
        $this->customer_id = $customer_id;
        $this->access_token = $access_token;
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function getPayerId(): string
    {
        return $this->payerId;
    }

    public function getCustomerId(): int
    {
        return $this->customer_id;
    }

    public function getAccessToken(): string
    {
        return $this->access_token;
    }
}
