<?php

namespace App\Services;

use Illuminate\Support\Facades\Artisan;

class SystemCacheService
{
    public function activate(): int
    {
        return Artisan::call('filament:cache-components');
    }

    public function deactivate(): int
    {
        return Artisan::call('filament:clear-cached-components');
    }
}
