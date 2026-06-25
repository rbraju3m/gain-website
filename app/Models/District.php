<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class District extends Model
{
    protected $fillable = [
        'name',
        'division_id',
        'lat',
        'lng',
        'is_active',
    ];

    protected $casts = [
        'lat'         => 'float',
        'lng'         => 'float',
        'is_active'   => 'boolean',
    ];

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
