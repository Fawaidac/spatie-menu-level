<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Menu;

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
        Gate::before(function ($user, $ability) {
            $parts = explode('.', $ability, 2);
            if (count($parts) === 2 && in_array($parts[1], Menu::ACTIONS, true)) {
                return $user->canMenu($parts[0], $parts[1]);
            }
            return null; // ability lain diproses seperti biasa
        });
    }
}
