<?php


namespace Application\Services\Payments;


use Application\Exceptions\InvalidPayment;
use Domain\Entities\Customer;
use Domain\ValueObjects\Payment;
use Money\Money;

class PaymentService
{
    const DEFAULT_GATEWAY = 'mercadopago';

    public function __construct()
    {

    }

    public function create(
        Money $amount,
        Customer $customer,
        string $gateway = self::DEFAULT_GATEWAY
    ) {
        if ($amount->isZero()){
            throw new InvalidPayment("Invalid payment, amount isn't 0");
        }

        if ($amount->isNegative()) {
            throw new InvalidPayment();
        }

        $payment = new Payment($amount, $customer->getClientTokenPaypal(), $customer->getId(), $gateway);

        $payment->setPayerId($customer->getId());

        return $payment;
    }
}
