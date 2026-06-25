<?php

namespace App\Models;

use App\Support\Icons;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    public const ROW_TONES = ['red', 'green', 'orange'];

    public const MAX_ROWS = 4;

    protected $fillable = [
        'title',
        'icon_key',
        'rows',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'rows'         => 'array',
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

    /** Return only rows that actually have a label set. */
    public function visibleRows(): array
    {
        return collect($this->rows ?? [])
            ->filter(fn ($r) => filled($r['label'] ?? null))
            ->values()
            ->all();
    }
}
