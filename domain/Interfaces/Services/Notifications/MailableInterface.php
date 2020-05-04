<?php


namespace Domain\Interfaces\Services\Notifications;


use Illuminate\Mail\Mailable;

interface MailableInterface
{
    public function fromNotifiable(NotifiableInterface $notifiable): Mailable;
}
