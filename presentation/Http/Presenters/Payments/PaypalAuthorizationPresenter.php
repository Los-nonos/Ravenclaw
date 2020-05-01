<?php


namespace Presentation\Http\Presenters\Payments;


class PaypalAuthorizationPresenter
{
    private $result;

    public function fromResult($result): PaypalAuthorizationPresenter
    {
        $this->result = $result;
        return $this;
    }

    public function getData(): array
    {
        return [
            'result' => $this->result
        ];
    }
}
