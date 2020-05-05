<?php


namespace Domain\Entities;


use DateTime;

class Token
{
    const LENGTH = 32;

    private User $user;
    private string $hash;
    private DateTime $createdAtDate;

    public function __construct()
    {

    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function setHash($handle): string
    {
        return $this->hash;
    }

    public function setCreatedAt(DateTime $param)
    {
        $this->createdAtDate = $param;
    }

    public function getCreatedAt(): DateTime {
        return $this->createdAtDate;
    }

    public function setUpdatedAt(DateTime $param)
    {

    }
}
