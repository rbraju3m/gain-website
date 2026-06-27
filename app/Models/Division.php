<?php

namespace App\Models;

use App\Support\HasHomepageCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Division extends Model
{
    use HasHomepageCache;

    public const CACHE_KEY = 'homepage:map';

    public static function homepageCacheKeys(): array
    {
        return [self::CACHE_KEY];
    }

    /**
     * Pre-computed structure for the public map: divisionInfo[] keyed by SVG
     * key + flat districts[] with x/y already projected to the SVG viewBox.
     */
    public static function forHomepage(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            $lngWest  = 88.05; $lngEast  = 92.65;
            $latNorth = 26.65; $latSouth = 20.55;
            $usableX  = 1368;  $offsetX  = 50;
            $usableY  = 2066;  $offsetY  = 78;

            $all       = self::ordered()->with('districts')->get();
            $info      = [];
            $districts = [];

            foreach ($all as $div) {
                $info[$div->key] = [
                    'name'                  => $div->name,
                    'families'              => $div->families ?: '—',
                    'programmes'            => $div->programmes,
                    'success'               => $div->success_rate ?: '—',
                    'total_districts'       => $div->districts->count(),
                    'active_districts'      => $div->districts->where('is_active', true)->count(),
                    'active_district_names' => $div->districts->where('is_active', true)->pluck('name')->values()->all(),
                ];

                foreach ($div->districts as $d) {
                    $districts[] = [
                        'name'     => $d->name,
                        'division' => $div->key,
                        'x'        => round(($d->lng - $lngWest)  / ($lngEast - $lngWest)  * $usableX + $offsetX, 1),
                        'y'        => round(($latNorth - $d->lat) / ($latNorth - $latSouth) * $usableY + $offsetY, 1),
                        'active'   => (bool) $d->is_active,
                    ];
                }
            }

            return ['divisionInfo' => $info, 'districts' => $districts];
        });
    }

    protected $fillable = [
        'key',
        'name',
        'families',
        'programmes',
        'success_rate',
        'sort_order',
    ];

    protected $casts = [
        'programmes' => 'integer',
        'sort_order' => 'integer',
    ];

    public function districts(): HasMany
    {
        return $this->hasMany(District::class)->orderBy('name');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function activeDistrictsCount(): int
    {
        return $this->districts->where('is_active', true)->count();
    }
}
