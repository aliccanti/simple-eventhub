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

    protected $fillable = [
        'organizer_id',
        'title',
        'description',
        'date',
        'ticket_price',
        'capacity',
        'tickets_sold',
    ];

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

}
