<?php


namespace Application\Queries\Query\Payments;


use Infrastructure\QueryBus\Query\QueryInterface;
use Money\Currency;
use Money\Money;

class PayPalAuthorizationQuery implements QueryInterface
{
    private int $customerId;
    private Money $amount;
    private string $access_token;

    public function __construct(int $customerId, string $amount, string $access_token)
    {
        $this->customerId = $customerId;
        $this->amount = new Money($amount, new Currency('ARS'));
        $this->access_token = $access_token;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getAccessToken(): string
    {
        return $this->access_token;
    }
}
