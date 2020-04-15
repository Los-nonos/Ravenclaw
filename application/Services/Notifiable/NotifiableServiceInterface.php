<?php


namespace Application\Services\Notifiable;


use Domain\Interfaces\Services\Notifications\NotifiableInterface;

interface NotifiableServiceInterface
{
    public function GetNotifiableData(): NotifiableInterface;
    public function SendEmail(NotifiableInterface $data): void;
    public function SendNotification(NotifiableInterface $notifiable): void;
}
