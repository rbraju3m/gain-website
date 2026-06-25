<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    protected $fillable = [
        'key',
        'name',
        'families',
        'programmes',
        'success_rate',
        'sort_order',
    ];

    protected $casts = [
        'programmes' => 'integer',
        'sort_order' => 'integer',
    ];

    public function districts(): HasMany
    {
        return $this->hasMany(District::class)->orderBy('name');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function activeDistrictsCount(): int
    {
        return $this->districts->where('is_active', true)->count();
    }
}
