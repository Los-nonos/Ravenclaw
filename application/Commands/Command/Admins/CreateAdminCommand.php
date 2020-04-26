<?php


namespace Application\Commands\Command\Admins;


use Domain\CommandBus\CommandInterface;

class CreateAdminCommand implements CommandInterface
{
    private $name;
    private $surname;
    private $username;
    private $email;
    private $password;
    private $role;

    public function __construct($name, $surname, $username, $email, $password, $role)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}
