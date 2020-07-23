<?php


namespace Application\Services\Payments;


use Domain\Entities\Customer;
use Domain\Entities\Order;
use Domain\ValueObjects\Payment;
use Money\Money;

interface PaypalServiceInterface
{
    public function execute(Payment $payment): Order;

    public function authorization(Customer $customer, Money $amount): Payment;

    public function createClient(?string $clientId, ?string $access_token): void;
}
