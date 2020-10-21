<?php


namespace Domain\Entities;


class Payer
{
    private int $id;
    private string $name;
    private string $surname;
    private string $email;

    public function getEmail()
    {
        return $this->email;
    }
}
