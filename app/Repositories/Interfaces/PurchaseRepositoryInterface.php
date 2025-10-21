<?php

namespace App\Repositories\Interfaces;

interface PurchaseRepositoryInterface
{
    public function quantityByUserAndEvent(int $userId, int $eventId): int;

}
