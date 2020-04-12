<?php


namespace Application\Services;


use Application\Commands\Customers\IndexCustomerCommand;
use Application\Results\Customers\IndexCustomerResultInterface;

interface CustomerServiceInterface
{
    public function indexCustomers(IndexCustomerCommand $command): IndexCustomerResultInterface;
}
