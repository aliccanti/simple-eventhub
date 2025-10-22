<?php

namespace App\Repositories;

use App\Models\Event;
use App\Repositories\Interfaces\EventRepositoryInterface;

class EventRepository implements EventRepositoryInterface
{
    public function getById(int $eventId): ?Event
    {
        return Event::find($eventId);
    }

    public function create(string $title, string $description, string $date, string $ticketPrice, int $capacity, int $organizerId): int
    {
        $event = Event::create([
            'title' => $title,
            'description' => $description,
            'date' => $date,
            'ticket_price' => $ticketPrice,
            'capacity' => $capacity,
            'organizer_id' => $organizerId,
        ]);

        return $event->id;

    }
}
