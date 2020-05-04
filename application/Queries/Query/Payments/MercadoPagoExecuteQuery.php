<?php


namespace Application\Queries\Query\Payments;



use Infrastructure\QueryBus\Query\QueryInterface;

class MercadoPagoExecuteQuery implements QueryInterface
{
    private string $access_token;
    private int $amount;
    private string $email_payer;
    private string $card_token;
    private string $payment_method;

    public function __construct(
        string $access_token,
        int $amount,
        string $email_payer,
        string $card_token,
        string $payment_method
    )
    {
        $this->access_token = $access_token;
        $this->amount = $amount;
        $this->email_payer = $email_payer;
        $this->card_token = $card_token;
        $this->payment_method = $payment_method;
    }

    public function getAccessToken(): string
    {
        return $this->access_token;
    }

    public function getAmount(): int
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
}
