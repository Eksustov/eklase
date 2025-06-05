<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('view-students-dashboard', function ($user) {
            return $user->hasRole('student') || $user->hasRole('admin');
        });

        Gate::define('view-teachers-dashboard', function ($user) {
            return $user->hasRole('teacher') || $user->hasRole('admin');
        });

        Gate::define('view-admins-dashboard', function ($user) {
            return $user->hasRole('admin');
        });
    }
}
