<?php


namespace Presentation\Http\Presenters\Customers;


use Application\Results\Customers\IndexCustomerResultInterface;
use Presentation\Interfaces\Customers\IndexCustomerPresenterInterface;

class IndexCustomerPresenter implements IndexCustomerPresenterInterface
{
    private IndexCustomerResultInterface $result;

    public function fromResult(IndexCustomerResultInterface $result): IndexCustomerPresenterInterface
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
