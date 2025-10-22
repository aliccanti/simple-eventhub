<?php

namespace App\DTO;

final class EventInputDto
{
    public function __construct(
        public string $title,
        public string $description,
        public string $date,
        public float $ticketPrice,
        public int $capacity,
        public int $organizerId,
    ) {}
}
