<?php


namespace Domain\ValueObjects;


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
    private $responseData;
    private $requestData;

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

    public function setPayerId(string $payerId): void
    {
        $this->payerId = $payerId;
    }

    public function getPayerId(): string
    {
        return $this->payerId;
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
        $this->requestData = $data;
    }

    public function setResponseData($data) {
        $this->responseData = $data;
    }

    public function getLastStatus()
    {
        return $this->lastStatus;
    }
}
