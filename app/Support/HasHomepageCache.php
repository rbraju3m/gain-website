<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

/**
 * Drops cache-busting hooks on a model. Whenever a row is saved or deleted,
 * every cache key in `homepageCacheKeys()` is forgotten so the next public
 * request rebuilds it.
 *
 * Each consumer model overrides homepageCacheKeys() to declare which keys
 * belong to it (usually 1, sometimes more — e.g. Partner has two: strategic
 * and implementing). Concrete read methods on each model wrap their queries
 * in Cache::rememberForever() under those same keys.
 */
trait HasHomepageCache
{
    protected static function bootHasHomepageCache(): void
    {
        $forget = function ($model) {
            foreach ($model::homepageCacheKeys() as $key) {
                Cache::forget($key);
            }
        };
        static::saved($forget);
        static::deleted($forget);
    }

    /**
     * Cache keys owned by this model. Override in the model.
     */
    public static function homepageCacheKeys(): array
    {
        return ['homepage:'.static::class];
    }
}
