<?php


namespace Domain\ValueObjects;


use Money\Money;

class Payment
{
    private string $authorization;

    private Money $amount;

    private int $customer_id;

    private string $type;

    private string $paymentId;

    private string $payerId;

    public function __construct(Money $amount, $authorization = "", int $customer_id = 0, string $type = "")
    {
        $this->authorization = $authorization;
        $this->amount = $amount;
        $this->customer_id = $customer_id;
        $this->type = $type;
    }

    public function getAuthorization(): string
    {
        return $this->authorization;
    }

    public function getAmount(): Money
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
