<?php


namespace Presentation\Http\Presenters\Payments;


use Application\Commands\Results\Payments\PaypalAuthorizationResultInterface;

class PaypalAuthorizationPresenter
{
    private PaypalAuthorizationResultInterface $result;

    public function fromResult(PaypalAuthorizationResultInterface $result): PaypalAuthorizationPresenter
    {
        $this->result = $result;
        return $this;
    }

    public function getData(): array
    {
        // TODO: Implement getData() method.
    }
}
