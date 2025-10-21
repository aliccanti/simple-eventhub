<?php

namespace App\Services;

use App\Jobs\PurchaseNotificationJob;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\NotificationServiceInterface;
use GuzzleHttp\Client;
use App\ValueObjects\Email;

class NotificationService implements NotificationServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function notify(Email $email, string $eventName): void
    {
        PurchaseNotificationJob::dispatch($email->value(), $eventName);
    }
}
