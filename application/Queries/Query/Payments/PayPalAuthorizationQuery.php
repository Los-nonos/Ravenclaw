<?php


namespace Application\Queries\Query\Payments;


use Infrastructure\QueryBus\Query\QueryInterface;

class PayPalAuthorizationQuery implements QueryInterface
{
    private int $customerId;
    private int $amount;
    private string $access_token;

    public function __construct(int $customerId, int $amount, string $access_token)
    {
        $this->customerId = $customerId;
        $this->amount = $amount;
        $this->access_token = $access_token;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getAccessToken(): string
    {
        return $this->access_token;
    }
}
