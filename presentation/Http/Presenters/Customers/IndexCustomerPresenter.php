<?php


namespace Presentation\Http\Presenters\Customers;


use Application\Queries\Results\Customers\IndexCustomerResult;
use Infrastructure\QueryBus\Result\ResultInterface;

class IndexCustomerPresenter
{
    private ResultInterface $result;

    public function fromResult(IndexCustomerResult $result): IndexCustomerPresenter
    {
        $this->result = $result;
        return $this;
    }

    public function getData(): array
    {
        $customers = $this->result->getCustomers();
        return [
            'customers' => $customers,
            'message' => 'customers has been found successfully',
        ];
    }
}
