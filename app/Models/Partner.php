<?php

namespace App\Models;

use App\Support\HasHomepageCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Partner extends Model implements HasMedia
{
    use HasHomepageCache, InteractsWithMedia;

    public const GROUP_STRATEGIC    = 'strategic';
    public const GROUP_IMPLEMENTING = 'implementing';

    public const CACHE_KEY_STRATEGIC    = 'homepage:partners.strategic';
    public const CACHE_KEY_IMPLEMENTING = 'homepage:partners.implementing';

    public static function homepageCacheKeys(): array
    {
        return [self::CACHE_KEY_STRATEGIC, self::CACHE_KEY_IMPLEMENTING];
    }

    public static function forHomepageStrategic()
    {
        return Cache::rememberForever(self::CACHE_KEY_STRATEGIC,
            fn () => self::published()->strategic()->ordered()->with('media')->get());
    }

    public static function forHomepageImplementing()
    {
        return Cache::rememberForever(self::CACHE_KEY_IMPLEMENTING,
            fn () => self::published()->implementing()->ordered()->with('media')->get());
    }

    public const GROUPS = [
        self::GROUP_STRATEGIC    => 'Strategic (static grid)',
        self::GROUP_IMPLEMENTING => 'Implementing (scrolling marquee)',
    ];

    protected $fillable = [
        'name',
        'slug',
        'group',
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
        $this->addMediaCollection('logo')
            ->singleFile()
            ->acceptsMimeTypes(['image/svg+xml', 'image/png', 'image/jpeg', 'image/webp']);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function scopeStrategic($query)
    {
        return $query->where('group', self::GROUP_STRATEGIC);
    }

    public function scopeImplementing($query)
    {
        return $query->where('group', self::GROUP_IMPLEMENTING);
    }

    public function logoUrl(): ?string
    {
        $url = $this->getFirstMediaUrl('logo');
        if ($url !== '') {
            return $url;
        }
        // Fallback to the demo SVG at public/images/partners/{slug}.svg if it exists.
        $relative = "images/partners/{$this->slug}.svg";
        return file_exists(public_path($relative)) ? asset($relative) : null;
    }

    public static function generateSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'partner';
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
