<?php


namespace Application\Results\Customers;


use Domain\Entities\Customer;

class CreateCustomerResult
{
    private Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}
