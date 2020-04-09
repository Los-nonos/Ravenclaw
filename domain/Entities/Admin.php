<?php


namespace Domain\Entities;


class Admin
{
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
