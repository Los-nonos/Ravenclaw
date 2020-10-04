<?php


namespace Application\Commands\Command\Payments;


use Infrastructure\CommandBus\Command\CommandInterface;

class ProcessPaymentsCommand implements CommandInterface
{
  private $amount;
  private $currency;
  private $customerId;
  private $gatewayId;
  private $paymentMethod;
  private $payerEmail;
  private $payerDni;
  private $payerName;
  private $token;
  private $bin;

  public function __construct(
    string $token,
    string $bin,
    int $customerId,
    string $gateway
  ) {
    $this->token = $token;
    $this->bin = $bin;
    $this->customerId = $customerId;
    $this->gateway = $gateway;
  }

  public function getAmount(): int
  {
      return $this->amount;
  }

  public function getCurrency(): string
  {
      return $this->currency;
  }

  public function getCustomerId(): int
  {
      return $this->customerId;
  }

  public function getGatewayId(): string
  {
      return $this->gatewayId;
  }

  public function getPayerEmail()
  {
      return $this->payerEmail;
  }

  public function getPayerDni()
  {
      return $this->payerDni;
  }

  public function getPayerName()
  {
      return $this->payerName;
  }

  public function getPaymentMethod()
  {
    return $this->paymentMethod;
  }

  public function getToken()
  {
    return $this->token;
  }

  public function getBin()
  {
    return $this->bin;
  }
}
