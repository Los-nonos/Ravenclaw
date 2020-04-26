<?php


namespace Presentation\Http\Presenters\Payments;


use Application\Commands\Results\Payments\PaypalExecuteResultInterface;

class PaypalExecutePresenter
{
    private PaypalExecuteResultInterface $result;

    public function fromResult(PaypalExecuteResultInterface $result): PaypalExecutePresenter
    {
        $this->result = $result;
        return $this;
    }

    public function getData(): array
    {
        return [

        ];
    }
}
