<?php

namespace App\Models;

use App\Support\HasHomepageCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class District extends Model
{
    use HasHomepageCache;

    /** Districts share the map cache key with Division; flipping is_active busts the same key. */
    public static function homepageCacheKeys(): array
    {
        return [Division::CACHE_KEY];
    }

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
