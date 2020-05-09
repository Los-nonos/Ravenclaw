<?php


namespace Presentation\Http\Presenters\Customers;


use Application\Queries\Results\Customers\IndexCustomerResult;

class IndexCustomerPresenter
{
    private IndexCustomerResult $result;

    public function fromResult($result): IndexCustomerPresenter
    {
        $this->result = $result;
        return $this;
    }

    public function getData(): array
    {
        $customers = $this->result->getCustomers();
        return [
            'customers' => serialize($customers),
            'message' => 'customers has been found successfully',
        ];
    }
}
