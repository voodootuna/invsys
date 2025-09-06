<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rental extends Model
{
    protected $fillable = [
        'equipment_item_id',
        'user_id',
        'from_location_id',
        'to_location_id',
        'taken_date',
        'expected_return_date',
        'returned_date',
        'returned_by_user_id',
        'status',
        'notes',
    ];

    protected $casts = [
        'taken_date' => 'datetime',
        'expected_return_date' => 'date',
        'returned_date' => 'datetime',
        'status' => 'string',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(EquipmentItem::class, 'equipment_item_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function returnedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'returned_by_user_id');
    }

    public function fromLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'from_location_id');
    }

    public function toLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'to_location_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isOverdue(): bool
    {
        return $this->status === 'active' 
            && $this->expected_return_date 
            && $this->expected_return_date->isPast();
    }
}