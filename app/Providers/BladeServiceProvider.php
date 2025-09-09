<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Safe role check directive
        Blade::directive('hasrole', function ($role) {
            return "<?php if(auth()->check() && auth()->user()->hasRole($role)): ?>";
        });

        Blade::directive('endhasrole', function () {
            return "<?php endif; ?>";
        });

        // Safe permission check directive
        Blade::directive('haspermission', function ($permission) {
            return "<?php if(auth()->check() && auth()->user()->hasPermissionTo($permission)): ?>";
        });

        Blade::directive('endhaspermission', function () {
            return "<?php endif; ?>";
        });

        // Safe user check directive
        Blade::directive('authuser', function () {
            return "<?php if(auth()->check()): ?>";
        });

        Blade::directive('endauthuser', function () {
            return "<?php endif; ?>";
        });
    }
}
