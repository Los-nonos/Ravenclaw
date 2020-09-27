<?php


namespace Application\Queries\Query\Payments;


use Infrastructure\QueryBus\Query\QueryInterface;

class ProcessPaymentQuery implements QueryInterface
{
    private $amount;
    private $currency;
    private $customerId;
    private $gatewayId;

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getGatewayId(): string
    {
        return $this->gatewayId;
    }
}
