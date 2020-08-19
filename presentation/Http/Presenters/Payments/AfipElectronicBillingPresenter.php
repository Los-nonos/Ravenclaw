<?php


namespace Presentation\Http\Presenters\Payments;


use Application\Queries\Results\Payments\AfipElectronicBillingResult;

class AfipElectronicBillingPresenter
{
    private AfipElectronicBillingResult $result;

    public function fromResult($result): AfipElectronicBillingPresenter
    {
        $this->result = $result;
        return $this;
    }

    public function getData(): array
    {
        return $this->result->getData();
    }
}
