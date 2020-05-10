<?php

declare(strict_types=1);

namespace Domain\Entities;

use Application\Exceptions\SettingRoleUserNotPermittedException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use function Sodium\add;

/**
 * Class User
 * @package Domain\Entities
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;
    /**
     * @var string
     * @ORM\Column(name="name")
     */
    private string $name;
    /**
     * @var string|null
     * * @ORM\Column(name="surname")
     */
    private ?string $surname;
    /**
     * @var string|null
     * @ORM\Column(name="username")
     */
    private ?string $username;
    /**
     * @var string
     * @ORM\Column(name="email")
     */
    private string $email;
    /**
     * @var string
     * @ORM\Column(name="password")
     */
    private string $password;
    /**
     * @var bool
     * @ORM\Column(name="is_active")
     */
    private bool $isActive;
    /**
     * @var Customer|null
     * @ORM\Column(name="customer_id")
     */
    private ?Customer $customer;
    /**
     * @var Admin|null
     * @ORM\OneToOne(targetEntity="Admin")
     * @ORM\JoinTable(name="user_x_admin",
     *     joinColumns={@ORM\JoinColumn(name="admin_id", referencedColumnName="id", onDelete="CASCADE", onUpdate="CASCADE")},
     * )
     */
    private ?Admin $admin;

    /**
     * Activity constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->isActive = true;
        $this->admin = null;
        $this->customer = null;
    }

    /**
     * @return string $name
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string $name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setSurname(?string $surname): void
    {
        $this->surname = $surname;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @return string $email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string $password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @param Customer $customer
     * @throws SettingRoleUserNotPermittedException
     */
    public function setCustomer(Customer $customer): void
    {
        if($this->isAdmin())
        {
            throw new SettingRoleUserNotPermittedException('you cannot set a user as admin and as customer');
        }

        $this->customer = $customer;
        $this->admin = null;
    }

    public function isCustomer(): bool
    {
        return $this->customer !== null;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @param Admin $admin
     * @throws SettingRoleUserNotPermittedException
     */
    public function setAdmin(Admin $admin): void
    {
        if($this->isCustomer())
        {
            throw new SettingRoleUserNotPermittedException('you cannot set a user as admin and as customer');
        }

        $this->admin = $admin;
        $this->customer = null;
    }

    public function isAdmin(): bool
    {
        return $this->admin !== null;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function __serialize()
    {
        return [
          'id' => $this->id,
          'name' => $this->name,
          'surname' => $this->surname,
          'email' => $this->email,
          'username' => $this->username,
          'is_active' => $this->isActive,
        ];
    }
}
