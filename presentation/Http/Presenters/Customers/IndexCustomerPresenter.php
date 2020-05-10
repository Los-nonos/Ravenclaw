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

        $customersClears = [];

        foreach ($customers as $customer)
        {
            $customersClears[] = $customer->__serialize();
        }

        return [
            'customers' => $customersClears,
            'message' => 'Customers has been found successfully',
        ];
    }
}
