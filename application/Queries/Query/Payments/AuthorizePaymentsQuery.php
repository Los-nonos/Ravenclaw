<?php


namespace Application\Queries\Query\Payments;


use Infrastructure\QueryBus\Query\QueryInterface;

class AuthorizePaymentsQuery implements QueryInterface
{
  private string $name;
  private string $expirationMonth;
  private string $expirationYear;
  private string $securityCode;
  private string $cardNumber;
  private string $gateway;
  private string $identification;

  public function __construct(
    string $name,
    string $expirationMonth,
    string $expirationYear,
    string $securityCode,
    string $cardNumber,
    string $identification,
    string $gateway
  ) {
    $this->name = $name;
    $this->expirationMonth = $expirationMonth;
    $this->expirationYear = $expirationYear;
    $this->securityCode = $securityCode;
    $this->cardNumber = $cardNumber;
    $this->gateway = $gateway;
    $this->identification = $identification;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getExpirationMonth(): string
  {
    return $this->expirationMonth;
  }

  public function getExpirationYear(): string
  {
    return $this->expirationYear;
  }

  public function getSecurityCode(): string
  {
    return $this->securityCode;
  }

  public function getCardNumber(): string
  {
    return $this->cardNumber;
  }

  public function getGateway()
  {
    return $this->gateway;
  }

  public function getIdentification()
  {
    return $this->identification;
  }
}
