<?php


namespace Application\Services;


use Domain\Entities\Customer;
use Domain\Entities\Order;

interface PaymentGateway
{
    public function execute(Customer $customer, Order $order);
}
