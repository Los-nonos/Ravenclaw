<?php


namespace Domain\Entities;


class Payment
{
    private $authorization;

    private int $amount;

    private int $customer_id;

    private string $type;

    private string $paymentId;

    private string $payerId;

    public function __construct($authorization, int $amount, int $customer_id, string $type)
    {
        $this->authorization = $authorization;
        $this->amount = $amount;
        $this->customer_id = $customer_id;
        $this->type = $type;
    }

    public function getAuthorization()
    {
        return $this->authorization;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCustomerId(): int
    {
        return $this->customer_id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setPaymentId(string $paymentId): void
    {
        $this->paymentId = $paymentId;
    }

    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    public function setPayerId(string $payerId): void
    {
        $this->payerId = $payerId;
    }

    public function getPayerId(): string
    {
        return $this->payerId;
    }
}
