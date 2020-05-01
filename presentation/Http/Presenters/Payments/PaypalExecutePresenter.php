<?php


namespace Presentation\Http\Presenters\Payments;


class PaypalExecutePresenter
{
    private $result;

    public function fromResult($result): PaypalExecutePresenter
    {
        $this->result = $result;
        return $this;
    }

    public function getData(): array
    {
        return [
            'result' => $this->result,
        ];
    }
}
