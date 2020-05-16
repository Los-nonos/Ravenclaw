<?php


namespace Application\Services\Payments;

use Domain\Entities\Customer;
use Domain\Entities\Order;
use Domain\ValueObjects\Payment;

interface MercadoPagoServiceInterface
{
    public function execute(Payment $payment): Order;
    public function generatePayment(string $access_token, int $amount, int $customerId): Payment;
    public function createClient(string $getAccessToken): void;
}
