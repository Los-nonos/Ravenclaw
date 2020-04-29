<?php


namespace Application\Queries\Handler\Customers;


use Application\Queries\Results\Customers\IndexCustomerResult;
use Domain\Entities\Customer;
use Infrastructure\QueryBus\Handler\HandlerInterface;
use Infrastructure\QueryBus\Query\QueryInterface;
use Infrastructure\QueryBus\Result\ResultInterface;

class IndexCustomerHandler implements HandlerInterface
{

    public function handle(QueryInterface $query): ResultInterface
    {
        // TODO: Implement handle() method.
        $result = new IndexCustomerResult();
        $result->setCustomers(array(new Customer('mockedDomain', 'mocked_organization')));

        return $result;
    }
}
