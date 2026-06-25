<?php

namespace App\Models;

use App\Support\Icons;
use Illuminate\Database\Eloquent\Model;

class ImpactStat extends Model
{
    public const TONES = ['red', 'green', 'orange'];

    protected $fillable = [
        'label',
        'counter',
        'suffix',
        'tone',
        'icon_key',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'counter'      => 'integer',
        'sort_order'   => 'integer',
        'is_published' => 'boolean',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function iconSvg(): ?string
    {
        return Icons::svg($this->icon_key);
    }
}
