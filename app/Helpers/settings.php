<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    /**
     * Read a site setting (dot-notation supported). Returns $default when the
     * key is missing OR the resolved value is null/empty string.
     */
    function setting(string $key, mixed $default = null): mixed
    {
        $value = Setting::get($key, $default);

        return ($value === null || $value === '') ? $default : $value;
    }
}
