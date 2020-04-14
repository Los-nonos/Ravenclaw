<?php


namespace Presentation\Interfaces\Payments;


use Application\Results\Payments\PaypalAuthorizationResultInterface;

interface PaypalAuthorizationPresenterInterface
{
    public function fromResult(PaypalAuthorizationResultInterface $result): PaypalAuthorizationPresenterInterface;
    public function getData(): array;
}
