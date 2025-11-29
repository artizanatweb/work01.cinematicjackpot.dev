<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::automaticallyEagerLoadRelationships();
        Model::unguard();

        // https://laravel.com/docs/12.x/routing#rate-limiting
        RateLimiter::for('web', function (Request $request) {
            return Limit::perMinute(6)->by($request->ip());
        });

//        RateLimiter::for('admin', function (Request $request) {
//            return Limit::perMinute(50)->by($request->user()?->id ?: $request->ip());
//        });
    }
}
