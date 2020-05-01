<?php


namespace Application\Queries\Query\Payments;


use Infrastructure\QueryBus\Query\QueryInterface;

class PayPalAuthorizationQuery implements QueryInterface
{
    private int $customerId;
    private int $amount;

    public function __construct(int $customerId, int $amount)
    {
        $this->customerId = $customerId;
        $this->amount = $amount;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
