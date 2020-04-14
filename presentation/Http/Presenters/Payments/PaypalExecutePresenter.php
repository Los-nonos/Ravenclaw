<?php


namespace Presentation\Http\Presenters\Payments;


use Application\Results\Payments\PaypalExecuteResultInterface;
use Presentation\Interfaces\Payments\PaypalExecutePresenterInterface;

class PaypalExecutePresenter implements PaypalExecutePresenterInterface
{
    private PaypalExecuteResultInterface $result;

    public function fromResult(PaypalExecuteResultInterface $result): PaypalExecutePresenterInterface
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
