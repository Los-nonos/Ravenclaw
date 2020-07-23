<?php


namespace Application\Queries\Query\Payments;



use Infrastructure\QueryBus\Query\QueryInterface;
use Money\Currency;
use Money\Money;

class MercadoPagoExecuteQuery implements QueryInterface
{
    private string $access_token;
    private Money $amount;
    private string $email_payer;
    private string $card_token;
    private string $payment_method;
    private int $customerId;


    public function __construct(
        string $access_token,
        int $amount,
        string $email_payer,
        string $card_token,
        string $payment_method,
        int $customerId
    )
    {
        $this->access_token = $access_token;
        $this->amount = new Money($amount, new Currency('ARS'));
        $this->email_payer = $email_payer;
        $this->card_token = $card_token;
        $this->payment_method = $payment_method;
        $this->customerId = $customerId;
    }

    public function getAccessToken(): string
    {
        return $this->access_token;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getEmailPayer(): string
    {
        return $this->email_payer;
    }

    public function getCartToken(): string
    {
        return $this->card_token;
    }

    public function getPaymentMethod(): string
    {
        return $this->payment_method;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }
}
