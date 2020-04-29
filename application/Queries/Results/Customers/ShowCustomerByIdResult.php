<?php


namespace Application\Queries\Results\Customers;


use Domain\Entities\Customer;
use Infrastructure\QueryBus\Result\ResultInterface;

class ShowCustomerByIdResult implements ResultInterface
{
    private Customer $customer;

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}
