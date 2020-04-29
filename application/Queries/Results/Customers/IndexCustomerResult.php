<?php


namespace Application\Queries\Results\Customers;


use Infrastructure\QueryBus\Result\ResultInterface;

class IndexCustomerResult implements ResultInterface
{
    private array $customers;

    public function setCustomers(array $customers): void
    {
        $this->customers = $customers;
    }

    public function getCustomers(): array
    {
        return $this->customers;
    }
}
