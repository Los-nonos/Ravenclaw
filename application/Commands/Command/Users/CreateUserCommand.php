<?php


namespace Application\Commands\Command\Users;



class CreateUserCommand
{
    private string $name;
    private string $surname;
    private string $username;
    private string $email;
    private string $password;

    public function __construct($name, $surname, $username, $email, $password)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): ?string
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

    public function getPassword(): string
    {
        return $this->password;
    }
}
