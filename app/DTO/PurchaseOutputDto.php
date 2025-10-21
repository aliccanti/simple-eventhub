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

    public function jsonSerialize(): array
    {
        return [
            'id'           => $this->id,
            'quantity'     => $this->quantity,
            'total_amount' => $this->totalAmount,
            'event'        => $this->eventId,
            'user'         => $this->userId,
        ];
    }
}
