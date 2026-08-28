<?php

use App\Models\Setting;

if (! function_exists('peso')) {
    function peso(float|int|string|null $amount): string
    {
        return '₱' . number_format((float) $amount, 2);
    }
}

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}

if (! function_exists('app_logo')) {
    function app_logo(): string
    {
        $logo = setting('shop_logo');

        if ($logo && file_exists(public_path('storage/' . $logo))) {
            return asset('storage/' . $logo);
        }

        return asset('images/logo.png');
    }
}
