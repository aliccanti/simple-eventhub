<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $table = 'events';

    public const LIMIT_TICKETS_PER_USER = 15;

    protected $fillable = [
        'organizer_id',
        'title',
        'description',
        'date',
        'ticket_price',
        'capacity',
        'tickets_sold',
    ];

    protected $casts = [
        'date' => 'date',
        'ticket_price' => 'decimal:2',
    ];

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function hasTicketsAvailable(): bool
    {
        return $this->tickets_sold < $this->capacity;
    }

    public function hasExceededCapacity(int $quantityTickets): bool
    {
        return $this->tickets_sold + $quantityTickets >= $this->capacity;
    }

    public function hasExceededUserLimitByEvent(int $userTotalTickets, int $quantityTickets): bool
    {
        return $userTotalTickets + $quantityTickets > self::LIMIT_TICKETS_PER_USER;
    }
}
