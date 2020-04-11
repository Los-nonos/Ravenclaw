<?php


namespace Application\Results\Customers;


interface IndexCustomerResultInterface
{
    public function setCustomers(array $customers): void;

    public function getCustomers(): array;
}
