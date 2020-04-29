<?php


namespace Domain\Interfaces\Services\Notifications;


use Illuminate\Contracts\Mail\Mailable;

interface NotifiableInterface
{
    public function getEmailFrom(): string;
    public function getNameFrom(): string;
    public function getSubject(): string;
    public function setSubject(string $subject): void;
    public function setEmailFrom(string $email): void;
    public function setNameFrom(string $name): void;
}
