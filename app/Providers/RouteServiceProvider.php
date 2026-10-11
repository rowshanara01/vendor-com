<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

                //customly added start
                // user api route
                    Route::middleware('api')
                    ->prefix('api/v1/user')
                    ->group(base_path('routes/api/v1/user.php'));
                // admin api route
                    Route::middleware('api')
                    ->prefix('api/v1/admin')
                    ->group(base_path('routes/api/v1/admin.php'));
                // seller api route
                    Route::middleware('api')
                    ->prefix('api/v1/seller')
                    ->group(base_path('routes/api/v1/seller.php'));
                //customly added end

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
