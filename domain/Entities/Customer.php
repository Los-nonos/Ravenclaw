<?php


namespace Domain\Entities;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class Customer
 * @package Domain\Entities
 * @ORM\Entity
 * @ORM\Table(name="customers")
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @var string|null
     * @ORM\Column(name="domain")
     */
    private ?string $domain;
    /**
     * @var string|null
     * @ORM\Column(name="organization_name")
     */
    private ?string $organization_name;

    public function __construct(?string $domain, ?string $organization_name)
    {
        $this->organization_name = $organization_name;
        $this->domain = $domain;
    }

    public function getId(): int
    {
        return $this->id;
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

    public function __toString()
    {
       return "$this->id";
    }
}
