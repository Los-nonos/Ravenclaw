<?php


namespace Application\Services\Payments;


use Application\Exceptions\InvalidPayment;
use Domain\Entities\Customer;
use Domain\Entities\Payer;
use Domain\Interfaces\Repositories\PaymentRepository;
use Domain\Entities\Payment;
use Money\Money;

class PaymentService
{
  const DEFAULT_GATEWAY = 'mercadopago';
  private PaymentRepository $repository;

  public function __construct(PaymentRepository $repository)
  {
    $this->repository = $repository;
  }

  public function create(
    Money $amount,
    Customer $customer,
    Payer $payer,
    string $gateway = self::DEFAULT_GATEWAY
  ) {
    if ($amount->isZero()){
        throw new InvalidPayment("Invalid payment, amount must be great than 0");
    }

    if ($amount->isNegative()) {
        throw new InvalidPayment("Invalid payment, amount must be great than 0");
    }

    if ($gateway === self::DEFAULT_GATEWAY) {
        //TODO: set customer into payment

        $payment = new Payment($amount, '', $customer->getId(), $gateway);
    }else {
        $payment = new Payment($amount);
    }

    $payment->setPayer($payer);

    return $payment;
  }

  public function save(Payment $payment)
  {
    $this->repository->save($payment);
  }
}
