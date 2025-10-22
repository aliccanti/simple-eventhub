<?php

namespace App\DTO;

use Carbon\Carbon;

final class EventOutputDto
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public Carbon $date,
        public float $ticketPrice,
        public int $capacity,
        public int $organizerId,
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'date       ' => $this->date,
            'ticket_price' => $this->ticketPrice,
            'capacity' => $this->capacity,
        ];
    }
}
