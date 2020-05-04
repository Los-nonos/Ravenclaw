<?php


namespace Presentation\Http\Presenters\Payments;


class MercadoPagoExecutePresenter
{
    private $result;

    public function fromResult($result): MercadoPagoExecutePresenter
    {
        $this->result = $result;
        return $this;
    }

    public function getData(): array {
        return [
            'result' => $this->result
        ];
    }
}
