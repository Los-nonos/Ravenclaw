<?php


namespace Application\Services\Payments;


use Domain\Entities\Customer;
use Domain\Entities\Order;
use Domain\Entities\Payment;

interface PaypalServiceInterface
{
    public function execute(Payment $payment): Order;

    public function authorization(Customer $customer, int $amount): Payment;

    public function createClient(string $clientId, string $access_token): void;
}
