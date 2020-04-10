<?php

declare(strict_types=1);

namespace Domain\Entities;

use Application\Exceptions\SettingRoleUserNotPermittedException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;
use function Sodium\add;

class User
{
    private int $id;
    private string $name;
    private string $surname;
    private string $username;
    private string $email;
    private string $password;
    private bool $isActive;
    private Customer $customer;
    private Admin $admin;

    /**
     * Activity constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->isActive = true;
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

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function getSurname(): string
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

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getUsername(): string
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
    }

    public function isAdmin(): bool
    {
        return $this->admin !== null;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }
}
