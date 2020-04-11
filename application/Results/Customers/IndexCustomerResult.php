<?php


namespace Application\Results\Customers;


class IndexCustomerResult implements IndexCustomerResultInterface
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
