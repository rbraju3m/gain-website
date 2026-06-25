<?php

namespace App\Models;

use App\Support\HasHomepageCache;
use App\Support\Icons;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class MvvCard extends Model
{
    use HasHomepageCache;

    public const TONES     = ['red', 'green', 'orange'];
    public const CACHE_KEY = 'homepage:mvv';

    protected $table = 'mvv_cards';

    public static function homepageCacheKeys(): array
    {
        return [self::CACHE_KEY];
    }

    public static function forHomepage()
    {
        return Cache::rememberForever(self::CACHE_KEY, fn () => self::published()->ordered()->get());
    }

    protected $fillable = [
        'title',
        'body',
        'tone',
        'icon_key',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
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
