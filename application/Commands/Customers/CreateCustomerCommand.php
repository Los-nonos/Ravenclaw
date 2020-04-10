<?php


namespace Application\Commands\Customers;


class CreateCustomerCommand
{
    private $name;
    private $surname;
    private $email;
    private $password;
    private $domain;
    private $organizationName;

    public function __construct($name, $surname, $email, $password, $domain, $organizationName)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;
        $this->domain = $domain;
        $this->organizationName = $organizationName;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSurname(): ?string
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

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function getOrganizationName(): ?string
    {
        return $this->organizationName;
    }
}
