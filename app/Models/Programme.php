<?php

namespace App\Models;

use App\Support\HasHomepageCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Programme extends Model implements HasMedia
{
    use HasHomepageCache, InteractsWithMedia;

    public const CACHE_KEY = 'homepage:programmes';

    public static function homepageCacheKeys(): array
    {
        return [self::CACHE_KEY];
    }

    /** Published programmes ordered for the homepage card grid. Cached forever; busted on save/delete. */
    public static function forHomepage()
    {
        return Cache::rememberForever(self::CACHE_KEY, fn () => self::published()->ordered()->with('media')->get());
    }

    protected $fillable = [
        'title',
        'category',
        'body',
        'url',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'sort_order'   => 'integer',
        'is_published' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /** First media URL on the 'image' collection, or null. */
    public function imageUrl(): ?string
    {
        $url = $this->getFirstMediaUrl('image');
        return $url !== '' ? $url : null;
    }
}
