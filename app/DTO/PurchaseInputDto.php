<?php

namespace App\DTO;

final class PurchaseInputDto
{
    public function __construct(
        public int $quantity,
        public int $eventId,
        public int $userId,
    ) {}
}
