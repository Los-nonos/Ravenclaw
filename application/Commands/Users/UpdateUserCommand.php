<?php


namespace Application\Commands\Users;


class UpdateUserCommand
{
    private $id;
    private $name;
    private $surname;
    private $email;
    private $username;

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
