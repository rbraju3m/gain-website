<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Programme extends Model implements HasMedia
{
    use InteractsWithMedia;

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
