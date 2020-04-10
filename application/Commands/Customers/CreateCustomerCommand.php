<?php


namespace Application\Commands\Customers;


class CreateCustomerCommand
{
    private string $name;
    private string $surname;
    private string $email;
    private string $password;
    private string $domain;
    private string $organizationName;

    public function __construct($name, $surname, $email, $password, $domain, $organizationName)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
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
