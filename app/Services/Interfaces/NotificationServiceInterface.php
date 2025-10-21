<?php

namespace App\Services\Interfaces;

use App\ValueObjects\Email;

interface NotificationServiceInterface
{
    public function notify(Email $email, string $eventName): void;
}
