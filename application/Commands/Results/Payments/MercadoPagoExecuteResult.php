<?php


namespace Application\Commands\Results\Payments;


use Domain\Entities\Order;

class MercadoPagoExecuteResult
{
    private Order $order;

    public function setOrder(Order $order): void {
        $this->order = $order;
    }

    public function getOrder(): Order {
        return $this->order;
    }
}
