<?php


namespace Application\Commands\Results\Payments;


use Domain\Entities\Order;

interface PaypalExecuteResultInterface
{
    public function setOrder(Order $order): void;
    public function getOrder(): Order;
}
