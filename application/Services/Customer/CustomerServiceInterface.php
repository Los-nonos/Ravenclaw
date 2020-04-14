<?php


namespace Application\Services\Customers;


use Application\Commands\Customers\IndexCustomerCommand;
use Application\Results\Customers\IndexCustomerResultInterface;
use Domain\Entities\Customer;

interface CustomerServiceInterface
{
    public function indexCustomers(IndexCustomerCommand $command): IndexCustomerResultInterface;
    public function findCustomerById($id): Customer;
}
