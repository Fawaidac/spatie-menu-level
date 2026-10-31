<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
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

        View::composer(['partials.sidebar', 'layouts.sidebar'], function ($view) {
            $user = auth()->user();
            if (!$user) {
                return;
            }

            $filter = function ($menus) use (&$filter, $user) {
                return $menus->filter(function ($m) use (&$filter, $user) {
                    if ($m->childrenRecursive->isEmpty()) {
                        return $user->canMenu($m->kode_menu, 'view');
                    }
                    $m->setRelation('childrenRecursive', $filter($m->childrenRecursive));
                    return $m->childrenRecursive->isNotEmpty(); // grup tampil jika ada anak yang boleh
                });
            };

            $view->with('sidebarMenus', $filter(
                Menu::whereNull('parent_id')->with('childrenRecursive')->orderBy('urutan')->get()
            ));
        });
    }
}
