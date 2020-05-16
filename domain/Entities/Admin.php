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
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(name="role")
     */
    private $role;

    public function __construct($function)
    {
        $this->role = $function;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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

//    public function __toString()
//    {
//        return "$this->id";
//    }

    public function __serialize():array
    {
        return [
            'id' => $this->id,
            'role' => $this->role
        ];
    }
}
