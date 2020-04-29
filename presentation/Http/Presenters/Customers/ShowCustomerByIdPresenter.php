<?php


namespace Presentation\Http\Presenters\Customers;


use Infrastructure\QueryBus\Result\ResultInterface;

class ShowCustomerByIdPresenter
{
    private ResultInterface $result;

    public function fromResult(ResultInterface $result): ShowCustomerByIdPresenter
    {
        $this->result = $result;
        return $this;
    }

    public function getData(): array {
        return [

        ];
    }
}
