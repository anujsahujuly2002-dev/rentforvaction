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
    private $adminNameSpace = 'App\Http\Controllers\Admin';
    private $frontendNameSpace = "App\Http\Controllers\Frontend";
    private $travllerNamespace = "App\Http\Controllers\Travller";
    private $ownerNamespace = "App\Http\Controllers\Owner";

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

            Route::middleware('web')
                ->namespace($this->frontendNameSpace)
                ->group(base_path('routes/web.php'));

            //Admin Route 
            Route::middleware('web')
                ->namespace($this->adminNameSpace)
                ->group(base_path('routes/admin.php'));

            // Travller Route
            Route::middleware('web')
            ->namespace($this->travllerNamespace)
            ->group(base_path('routes/traveller.php'));

            // Owner Route
            Route::middleware('web')
            ->namespace($this->ownerNamespace)
            ->group(base_path('routes/owner.php'));
        });
    }
}
