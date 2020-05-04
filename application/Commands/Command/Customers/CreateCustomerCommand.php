<?php


namespace Application\Commands\Command\Customers;


use Infrastructure\CommandBus\Command\CommandInterface;

class CreateCustomerCommand implements CommandInterface
{
    private $name;
    private $surname;
    private $email;
    private $username;
    private $password;
    private $domain;
    private $organizationName;

    public function __construct($name, $surname, $username, $email, $password, $domain, $organizationName)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->domain = $domain;
        $this->organizationName = $organizationName;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function getOrganizationName(): string
    {
        return $this->organizationName;
    }
}
