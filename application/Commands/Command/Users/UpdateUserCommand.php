<?php


namespace Application\Commands\Command\Users;


use Infrastructure\CommandBus\Command\CommandInterface;

class UpdateUserCommand implements CommandInterface
{
    private int $id;
    private string $name;
    private string $surname;
    private string $email;
    private string $username;

    public function __construct($id, $name, $surname, $username, $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->username = $username;
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getUsername(): string
    {
        return $this->username;
    }
}
