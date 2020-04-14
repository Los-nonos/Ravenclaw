<?php


namespace Presentation\Interfaces\Payments;


use Application\Results\Payments\PaypalExecuteResultInterface;

interface PaypalExecutePresenterInterface
{
    public function fromResult(PaypalExecuteResultInterface $result): PaypalExecutePresenterInterface;
    public function getData(): array;
}
