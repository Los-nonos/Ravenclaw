<?php


namespace Application\Services;

use Domain\Entities\Order;
use Domain\Entities\Payment;

interface PaymentGateway
{
    public function execute(Payment $payment, Order $order);
}
