<?php


namespace Application\Services\Notifiable;

use Application\Jobs\NotificationJob as EmailJob;
use Domain\Interfaces\Services\Notifications\MailableInterface;
use Domain\Interfaces\Services\Notifications\NotifiableInterface;

class NotifiableService implements NotifiableServiceInterface
{
    private GenerateNotificationService $generateNotificationService;
    private MailableInterface $mailable;

    public function __construct(GenerateNotificationService $generateNotificationService, MailableInterface $mailable)
    {
        $this->generateNotificationService = $generateNotificationService;
        $this->mailable = $mailable;
    }

    public function GetNotifiableData(): NotifiableInterface
    {
        return $this->generateNotificationService->Generate();
    }

    public function SendEmail(NotifiableInterface $data): void
    {
        EmailJob::dispatch($this->mailable->fromNotifiable($data))->onQueue('emails');
    }

    public function SendNotification(NotifiableInterface $notifiable): void
    {
        // TODO: Implement SendNotification() method.
    }
}
