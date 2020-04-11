<?php


namespace Application\Services;


use Domain\Entities\Customer;
use Domain\Entities\Order;

interface PaymentGatewayAuthorization
{
    public function Authorization(Customer $customer, int $amount): Order;
}
