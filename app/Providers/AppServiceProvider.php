<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
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

        Gate::define('menu-staff', function ($user) {
            return auth('staff')->check();
        });

        Gate::define('menu-admin', function ($user) {
            return Auth::guard('admin')->check() && Auth::guard('admin')->user()->role == 'admin';
        });

        Gate::define('menu-approver', function ($user) {
            return Auth::guard('admin')->check() && Auth::guard('admin')->user()->role == 'approver';
        });

        Gate::define('menu-hrAdmin', function ($user) {
            return Auth::guard('admin')->check() && Auth::guard('admin')->user()->role == 'hr_admin';
        });

        Gate::define('menu-payroll', function ($user) {
            return Auth::guard('admin')->check() && Auth::guard('admin')->user()->role == 'payroll';
        });
    }
}