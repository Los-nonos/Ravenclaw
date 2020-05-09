<?php


namespace Application\Queries\Results\Customers;


use Domain\Entities\Customer;
use Infrastructure\QueryBus\Result\ResultInterface;

class IndexCustomerResult implements ResultInterface
{
    private array $customers;

    /**
     * @param Customer[] $customers
     */
    public function setCustomers(array $customers): void
    {
        $this->customers = $customers;
    }

    /**
     * @return Customer[]
     */
    public function getCustomers()
    {
        return $this->customers;
    }
}
