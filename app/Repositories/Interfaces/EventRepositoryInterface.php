<?php

namespace App\Repositories\Interfaces;

use App\Models\Event;
use Carbon\Carbon;

interface EventRepositoryInterface
{
    public function getById(int $eventId): ?Event;

    public function create(string $title, string $description, Carbon $date, float $ticketPrice, int $capacity, string $organizerId): Event;
}
