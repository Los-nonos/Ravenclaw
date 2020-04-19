<?php


namespace Application\Queries\Query\Customers;


class IndexCustomerQuery
{
    private $page;
    private $size;
    private $name;
    private $surname;
    private $username;
    private $email;
    private $organizationName;
    private $domain;

    public function __construct($page, $size, $name, $surname, $username, $email, $organizationName, $domain)
    {
        $this->page = $page;
        $this->size = $size;
        $this->name = $name;
        $this->surname = $surname;
        $this->username = $username;
        $this->email = $email;
        $this->domain = $domain;
        $this->organizationName = $organizationName;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getEmail(): ?string
    {
        return $this->email;
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
