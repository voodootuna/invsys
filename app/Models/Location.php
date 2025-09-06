<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $fillable = [
        'name',
        'type',
        'address',
        'contact_name',
        'contact_phone',
        'is_active',
    ];

    protected $casts = [
        'type' => 'string',
        'is_active' => 'boolean',
    ];

    public function equipment(): HasMany
    {
        return $this->hasMany(EquipmentItem::class, 'current_location_id');
    }

    public function equipmentItems(): HasMany
    {
        return $this->hasMany(EquipmentItem::class, 'current_location_id');
    }

    public function rentalsFrom(): HasMany
    {
        return $this->hasMany(Rental::class, 'from_location_id');
    }

    public function rentalsTo(): HasMany
    {
        return $this->hasMany(Rental::class, 'to_location_id');
    }
}