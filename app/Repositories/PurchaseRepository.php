<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Repositories\Interfaces\PurchaseRepositoryInterface;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    public function quantityByUserAndEvent(int $userId, int $eventId): int
    {
        return Purchase::where('user_id', $userId)
            ->where('event_id', $eventId)
            ->sum('quantity');
    }
}
