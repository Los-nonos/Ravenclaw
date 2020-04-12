<?php


namespace Application\Services;


use Domain\Entities\Customer;
use Domain\Entities\Payment;

interface PaymentGatewayAuthorization
{
    public function Authorization(Customer $customer, int $amount): Payment;
}
