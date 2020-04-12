<?php


namespace Application\Services;

use Domain\Entities\Order;
use Domain\Entities\Payment;

interface PaymentGatewayInterface
{
    public function execute(Payment $payment);
}
