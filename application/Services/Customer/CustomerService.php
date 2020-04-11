<?php


namespace Application\Services\Customer;

use Application\Results\Customers\IndexCustomerResultInterface;
use Domain\Interfaces\Repositories\CustomerRepositoryInterface;

class CustomerService implements CustomerServiceInterface
{
    private CustomerRepositoryInterface $repository;

    public function __construct(CustomerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function indexCustomers($command): IndexCustomerResultInterface
    {
        // TODO: Implement indexCustomers() method.
    }
}
