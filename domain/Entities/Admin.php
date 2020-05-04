<?php


namespace Domain\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Admin
 * @package Domain\Entities
 * @ORM\Entity
 * @ORM\Table(name="admins")
 */
class Admin
{
    /**
     * @var string
     */
    private string $role;

    public function __construct($function)
    {
        $this->role = $function;
    }

    public function isMaintainer(): bool
    {
        return $this->role === "maintainer";
    }

    public function setMaintainer(): void
    {
        $this->role = "maintainer";
    }

    public function getRole(): string
    {
        return $this->role;
    }
}
