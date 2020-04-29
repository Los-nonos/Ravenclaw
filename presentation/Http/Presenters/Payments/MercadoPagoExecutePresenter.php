<?php


namespace Presentation\Http\Presenters\Payments;


use Application\Commands\Results\Payments\MercadoPagoExecuteResult;

class MercadoPagoExecutePresenter
{
    private MercadoPagoExecuteResult $result;

    public function fromResult(MercadoPagoExecuteResult $result): MercadoPagoExecutePresenter
    {
        $this->result = $result;
        return $this;
    }

    public function getData(): array {
        return [

        ];
    }
}
