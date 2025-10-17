<?php

namespace App\DTO;

use Carbon\Carbon;

final class EventInputDto
{
    public function __construct(
        public string $title,
        public string $description,
        public Carbon $date,
        public float $ticketPrice,
        public int $capacity,
        public int $organizerId,
    ) {}
}
