<?php


namespace Domain\Interfaces\Repositories;


use Domain\Entities\Payment;

interface PaymentRepository
{
  public function save(Payment $payment): void;

  public function findOneById(): ?Payment;
}
