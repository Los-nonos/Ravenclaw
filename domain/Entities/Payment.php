<?php


namespace Domain\Entities;


use DateTimeImmutable;
use Money\Money;

class Payment
{
  private string $authorization;

  private Money $amount;

  private int $customer_id;

  private string $gateway;

  private string $paymentId;

  private string $payerId;

  private string $lastStatus;
  private string $responseData;
  private string $requestData;
  private string $description;
  private Payer $payer;
  private int $id;
  private string $params;
  private int $externalId;
  private DateTimeImmutable $paidDate;
  private string $state;

  public function __construct(Money $amount, $authorization = "", int $customer_id = 0, string $gateway = "")
  {
      $this->authorization = $authorization;
      $this->amount = $amount;
      $this->customer_id = $customer_id;
      $this->gateway = $gateway;
  }

  public function getAuthorization(): string
  {
      return $this->authorization;
  }

  public function getTransactionAmount(): Money
  {
      return $this->amount;
  }

  public function getCustomerId(): int
  {
      return $this->customer_id;
  }

  public function getGateway(): string
  {
      return $this->gateway;
  }

  public function setPaymentId(string $paymentId): void
  {
      $this->paymentId = $paymentId;
  }

  public function getPaymentId(): string
  {
      return $this->paymentId;
  }

  public function setPayer(Payer $payer): void
  {
      $this->payer = $payer;
  }

  public function getPayer(): Payer
  {
      return $this->payer;
  }

  public function setLastStatus(string $status)
  {
      $this->lastStatus = $status;
  }

  public function setApprovedDate(string $date)
  {
      $this->approvedDate = $date;
  }

  public function setRequestData($data) {
      $this->requestData = json_encode($data);
  }

  public function setResponseData($data) {
      $this->responseData = json_encode($data);
  }

  public function getLastStatus()
  {
      return $this->lastStatus;
  }

  public function getDescription()
  {
      return $this->description;
  }

  public function getId()
  {
      return $this->id;
  }

  public function getRequestData()
  {
      return json_decode($this->requestData);
  }

  public function getParams()
  {
      return json_decode($this->params);
  }

  public function setExternalId(int $param)
  {
      $this->externalId = $param;
  }

  public function getResponseData()
  {
      return json_decode($this->responseData);
  }

  public function getParam(string $key)
  {
    $params = $this->getParams();
    return isset($params[$key]) ? $params[$key] : null;
  }

  public function setPaidDate(DateTimeImmutable $param)
  {
    $this->paidDate = $param;
  }

  public function setState(string $state)
  {
    $this->state = $state;
  }
}
