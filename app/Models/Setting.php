<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = ['key', 'value'];

    protected $casts = [
        'value' => 'json',
    ];

    public $timestamps = true;

    private const CACHE_KEY = 'site_settings_all';

    /** Per-request memoisation: avoids re-hitting the cache store for every setting() call. */
    private static ?array $memo = null;

    public static function get(string $key, mixed $default = null): mixed
    {
        $all = self::all_cached();
        return array_key_exists($key, $all) ? $all[$key] : $default;
    }

    public static function set(string $key, mixed $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        self::flush();
    }

    public static function setMany(array $pairs): void
    {
        foreach ($pairs as $key => $value) {
            self::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        self::flush();
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
        self::$memo = null;
    }

    private static function all_cached(): array
    {
        return self::$memo ??= Cache::rememberForever(self::CACHE_KEY, function () {
            return self::query()->pluck('value', 'key')->toArray();
        });
    }
}
