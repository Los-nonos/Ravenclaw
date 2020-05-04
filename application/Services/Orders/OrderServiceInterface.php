<?php


namespace Application\Services\Orders;


use Domain\Entities\Order;

interface OrderServiceInterface
{
    public function Persist(Order $order): void;
}
