<?php


namespace Infrastructure\Payments\Interfaces;


use Infrastructure\Payments\ValueObjects\PaymentParams;

interface AuthorizableGateway
{
  public function authorize(PaymentParams $paymentParams): array;
}
