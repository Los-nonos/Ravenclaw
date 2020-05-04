<?php


namespace Application\Services\Customer;


use Application\Queries\Query\Customers\IndexCustomerQuery;
use Application\Queries\Results\Customers\IndexCustomerResult;
use Domain\Entities\Customer;

interface CustomerServiceInterface
{
    public function indexCustomers(IndexCustomerQuery $command): IndexCustomerResult;
    public function findCustomerByIdOrFail($id): Customer;
    public function destroyOrFail($getId);
}
