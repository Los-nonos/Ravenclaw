<?php


namespace Application\Commands\Command\Payments;



use Infrastructure\CommandBus\Command\CommandInterface;

class MercadoPagoExecuteCommand implements CommandInterface
{
    public function __construct()
    {

    }

    public function getAccessToken(): string
    {

    }

    public function getAmount(): int
    {

    }

    public function getEmailPayer(): string
    {

    }

    public function getCartToken(): string
    {

    }

    public function getPaymentMethod(): string
    {

    }
}
