<?php

namespace App\Repositories\Interfaces;

use App\Models\Event;

interface EventRepositoryInterface
{
    public function getById(int $eventId): ?Event;

    public function create(string $title, string $description, string $date, string $ticketPrice, int $capacity, int $organizerId): int;
}
