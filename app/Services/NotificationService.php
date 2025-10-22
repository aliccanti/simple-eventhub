<?php

namespace App\Services;

use App\Jobs\PurchaseNotificationJob;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\NotificationServiceInterface;
use App\ValueObjects\Email;
use Illuminate\Support\Facades\Log;

class NotificationService implements NotificationServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function notify(Email $email, string $eventName): void
    {
        Log::debug('Notificando o usuário '.$email->value().' sobre o evento '.$eventName);
        
        PurchaseNotificationJob::dispatch($email->value(), $eventName);
    }
}
