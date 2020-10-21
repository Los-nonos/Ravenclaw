<?php


namespace Application\Queries\Query\Auth;


use Infrastructure\QueryBus\Query\QueryInterface;

class RenewTokenQuery implements QueryInterface
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
