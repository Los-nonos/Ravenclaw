<?php


namespace Application\Queries\Results\Customers;


interface IndexCustomerResultInterface
{
    public function setCustomers(array $customers): void;

    public function getCustomers(): array;
}
