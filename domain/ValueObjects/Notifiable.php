<?php


namespace Domain\ValueObjects;


use Domain\Interfaces\Services\Notifications\NotifiableInterface;

class Notifiable implements NotifiableInterface
{
    private string $emailFrom;
    private string $name;
    private string $subject;

    public function getEmailFrom(): string
    {
        return $this->emailFrom;
    }

    public function getNameFrom(): string
    {
        return $this->name;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function setEmailFrom(string $email): void
    {
        $this->emailFrom = $email;
    }

    public function setNameFrom(string $name): void
    {
        $this->name = $name;
    }
}
