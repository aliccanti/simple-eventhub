<?php

namespace App\DTO;

final class EventOutputDto
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public string $date,
        public float $ticketPrice,
        public int $capacity,
        public int $organizerId,
    ) {}
}
