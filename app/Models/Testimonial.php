<?php

namespace App\Models;

use App\Support\HasHomepageCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Testimonial extends Model implements HasMedia
{
    use HasHomepageCache, InteractsWithMedia;

    public const CACHE_KEY = 'homepage:testimonials';

    public static function homepageCacheKeys(): array
    {
        return [self::CACHE_KEY];
    }

    public static function forHomepage()
    {
        return Cache::rememberForever(self::CACHE_KEY,
            fn () => self::published()->ordered()->with('media')->get());
    }

    protected $fillable = [
        'author_name',
        'author_role',
        'quote',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'sort_order'   => 'integer',
        'is_published' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')
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

    /** First photo URL, or null. */
    public function photoUrl(): ?string
    {
        $url = $this->getFirstMediaUrl('photo');
        return $url !== '' ? $url : null;
    }
}
