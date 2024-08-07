<?php

namespace App\Providers;

use App\Actions\Rental\RentalIndexAction;
use App\Actions\Rental\RentalStoreAction;
use App\Contracts\Rental\RentalActionIndexContracts;
use App\Contracts\Rental\RentalActionStoreContracts;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RentalActionStoreContracts::class, RentalStoreAction::class);
        $this->app->bind(RentalActionIndexContracts::class, RentalIndexAction::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
