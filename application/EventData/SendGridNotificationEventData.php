<?php


namespace Application\EventData;

use Domain\Interfaces\Services\Notifications\MailableInterface;
use Domain\Interfaces\Services\Notifications\NotifiableInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendGridNotificationEventData extends Mailable implements MailableInterface
{
    use Queueable, SerializesModels;

    private NotifiableInterface $emailData;

    public function fromNotifiable(NotifiableInterface $notificable): Mailable
    {
        $this->emailData = $notificable;
        return $this;
    }

    public function build()
    {
        return $this->view('email.test')
            ->from($this->emailData->getEmailFrom(),$this->emailData->getNameFrom())
            ->subject($this->emailData->getSubject());
    }
}
