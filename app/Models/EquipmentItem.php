<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EquipmentItem extends Model
{
    protected $fillable = [
        'name',
        'type',
        'status',
        'current_location_id',
        'serial_number',
        'purchase_date',
        'notes',
        'photo_path',
    ];

    protected $casts = [
        'status' => 'string',
        'purchase_date' => 'date',
    ];

    public function currentLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'current_location_id');
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    public function activeRental(): HasOne
    {
        return $this->hasOne(Rental::class)->where('status', 'active');
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isRented(): bool
    {
        return $this->status === 'rented';
    }

    public function isBroken(): bool
    {
        return $this->status === 'broken';
    }
}