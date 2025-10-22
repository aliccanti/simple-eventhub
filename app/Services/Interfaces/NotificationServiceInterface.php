<?php

namespace App\Services\Interfaces;

use App\ValueObjects\Mail;

interface NotificationServiceInterface
{
    public function notify(Mail $email, string $eventName): void;
}
