<?php

namespace App\Models;

use App\Support\HasHomepageCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class NewsArticle extends Model implements HasMedia
{
    use HasHomepageCache, InteractsWithMedia;

    public const CACHE_KEY = 'homepage:news';

    public static function homepageCacheKeys(): array
    {
        return [self::CACHE_KEY];
    }

    /** 3 newest published articles for the homepage. Cached forever; busted on save/delete. */
    public static function forHomepage()
    {
        return Cache::rememberForever(self::CACHE_KEY, fn () => self::published()->newest()->with('media')->take(3)->get());
    }

    protected $fillable = [
        'title',
        'slug',
        'category',
        'excerpt',
        'body',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function scopeNewest($query)
    {
        return $query->orderByDesc('published_at')->orderByDesc('id');
    }

    public function imageUrl(): ?string
    {
        $url = $this->getFirstMediaUrl('image');
        return $url !== '' ? $url : null;
    }

    /** Make a unique slug from the title, avoiding collision with $ignoreId. */
    public static function generateSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'article';
        $slug = $base;
        $n    = 2;

        while (static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = "{$base}-{$n}";
            $n++;
        }
        return $slug;
    }
}
