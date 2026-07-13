<?php

namespace App\Models;

use App\Support\HasHomepageCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class GalleryYear extends Model
{
    use HasHomepageCache;

    public const CACHE_KEY = 'gallery:public';

    public static function homepageCacheKeys(): array
    {
        return [self::CACHE_KEY];
    }

    protected $fillable = [
        'year',
        'title',
        'description',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'year'         => 'integer',
        'sort_order'   => 'integer',
        'is_published' => 'boolean',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('year');
    }

    /** Published years with their published, media-loaded images. */
    public static function forPublic()
    {
        return Cache::rememberForever(self::CACHE_KEY, fn () => self::published()
            ->ordered()
            ->with(['images' => fn ($q) => $q->where('is_published', true)->with('media')])
            ->get()
            ->filter(fn ($y) => $y->images->isNotEmpty())
            ->values());
    }
}
