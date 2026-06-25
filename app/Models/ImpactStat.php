<?php

namespace App\Models;

use App\Support\HasHomepageCache;
use App\Support\Icons;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ImpactStat extends Model
{
    use HasHomepageCache;

    public const TONES = ['red', 'green', 'orange'];
    public const CACHE_KEY = 'homepage:impact';

    public static function homepageCacheKeys(): array
    {
        return [self::CACHE_KEY];
    }

    public static function forHomepage()
    {
        return Cache::rememberForever(self::CACHE_KEY, fn () => self::published()->ordered()->get());
    }

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
