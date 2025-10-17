<?php

namespace App\Repositories;

use App\Models\Event;
use App\Repositories\Interfaces\EventRepositoryInterface;
use Carbon\Carbon;

class EventRepository implements EventRepositoryInterface
{
    public function create(string $title, string $description, Carbon $date, float $ticketPrice, int $capacity, string $organizerId): Event
    {
        return Event::create([
            'title' => $title,
            'description' => $description,
            'date' => $date->format('Y-m-d'),
            'ticket_price' => $ticketPrice,
            'capacity' => $capacity,
            'organizer_id' => $organizerId
        ]);
    }
}
