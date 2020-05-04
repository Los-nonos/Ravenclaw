<?php


namespace Application\Queries\Results\Payments;


use Domain\Entities\Order;
use Infrastructure\QueryBus\Result\ResultInterface;

class PaypalExecuteResult implements ResultInterface
{
    private Order $order;

    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}
