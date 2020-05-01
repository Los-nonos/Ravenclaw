<?php


namespace Presentation\Http\Presenters\Customers;


class IndexCustomerPresenter
{
    private $result;

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
