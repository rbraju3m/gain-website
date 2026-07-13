<?php

namespace App\Models;

use App\Support\HasHomepageCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class GalleryImage extends Model implements HasMedia
{
    use HasHomepageCache, InteractsWithMedia;

    /** Editing/deleting an image busts the parent year's cached payload. */
    public static function homepageCacheKeys(): array
    {
        return [GalleryYear::CACHE_KEY];
    }

    protected $fillable = [
        'gallery_year_id',
        'title',
        'description',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'gallery_year_id' => 'integer',
        'sort_order'      => 'integer',
        'is_published'    => 'boolean',
    ];

    public function year(): BelongsTo
    {
        return $this->belongsTo(GalleryYear::class, 'gallery_year_id');
    }

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

    public function imageUrl(): ?string
    {
        $url = $this->getFirstMediaUrl('image');
        return $url !== '' ? $url : null;
    }
}
