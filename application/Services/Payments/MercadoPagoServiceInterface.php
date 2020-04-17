<?php


namespace Application\Services\Payments;

use Domain\Entities\Customer;
use Domain\Entities\Order;
use Domain\Entities\Payment;

interface MercadoPagoServiceInterface
{
    public function Execute(Payment $payment): Order;
    public function GeneratePayment(string $access_token, int $amount): Payment;
    public function CreateClient(string $getAccessToken): void;
}
