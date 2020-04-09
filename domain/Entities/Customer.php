<?php


namespace Domain\Entities;


class Customer
{
    private string $domain;
    private string $organization_name;

    public function __construct(string $domain, string $organization_name)
    {
        $this->organization_name = $organization_name;
        $this->domain = $domain;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }
    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    public function getOrganizationName(): string
    {
        return $this->organization_name;
    }

    public function setOrganizationName($organization_name): void
    {
        $this->organization_name = $organization_name;
    }
}
