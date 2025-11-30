<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\ProductSignageRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Repositories\Interfaces\UserRepository::class, UserRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\LanguageRepository::class, LanguageRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\CurrencyRepository::class, CurrencyRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\ProductSignageRepository::class, ProductSignageRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
