<?php


namespace Application\Services\Notifiable;


use Domain\Interfaces\Services\Notifications\NotifiableInterface;
use Illuminate\Contracts\Mail\Mailable;

class GenerateNotificationService
{
    private NotifiableInterface $notifiable;

    public function __construct(NotifiableInterface $notifiable)
    {
        $this->notifiable = $notifiable;
    }

    public function Generate(): NotifiableInterface
    {
        $email = env('MAIL_FROM_ADDRESS');
        $name = env('MAIL_FROM_NAME');

        $this->notifiable->setEmailFrom($email);
        $this->notifiable->setNameFrom($name);

        return $this->notifiable;
    }
}
