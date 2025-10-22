<?php

namespace App\DTO;

final class PurchaseOutputDto
{
    public function __construct(
        public int $id,
        public int $quantity,
        public int $eventId,
        public int $userId,
        public float $totalAmount,
    ) {}
}
