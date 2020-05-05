<?php


namespace Application\Queries\Query\Auth;


use Infrastructure\QueryBus\Query\QueryInterface;

class LoginQuery implements QueryInterface
{
    private string $username;
    private string $password;

    /**
     * LoginQuery constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getPassword(): string {
        return $this->password;
    }
}
