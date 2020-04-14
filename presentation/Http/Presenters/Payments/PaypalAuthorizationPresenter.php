<?php


namespace Presentation\Http\Presenters\Payments;


use Application\Results\Payments\PaypalAuthorizationResultInterface;
use Presentation\Interfaces\Payments\PaypalAuthorizationPresenterInterface;

class PaypalAuthorizationPresenter implements PaypalAuthorizationPresenterInterface
{
    private PaypalAuthorizationResultInterface $result;

    public function fromResult(PaypalAuthorizationResultInterface $result): PaypalAuthorizationPresenterInterface
    {
        $this->result = $result;
        return $this;
    }

    public function getData(): array
    {
        // TODO: Implement getData() method.
    }
}
