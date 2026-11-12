<?php

namespace App\Providers;

use App\Models\Menu;
use App\Support\SessionUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

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
        Paginator::defaultView('partials.pagination');
        Paginator::defaultSimpleView('partials.pagination');

        // Sidebar View Composer — menggunakan session_user()
        View::composer(['partials.sidebar', 'layouts.sidebar', 'partials.mobile-drawer'], function ($view) {
            $sessionUser = session_user();

            if (! $sessionUser) {
                $view->with('sidebarMenus', collect());
                return;
            }

            $filter = function ($menus) use (&$filter, $sessionUser) {
                return $menus->filter(function ($m) use (&$filter, $sessionUser) {
                    if ($m->childrenRecursive->isEmpty()) {
                        return $sessionUser->canMenu($m->kode_menu, 'view')
                            || $sessionUser->canMenu((string) $m->id, 'view')
                            || $sessionUser->canMenu((string) $m->url, 'view');
                    }
                    $m->setRelation('childrenRecursive', $filter($m->childrenRecursive));
                    return $m->childrenRecursive->isNotEmpty();
                });
            };

            $view->with('sidebarMenus', $filter(
                Menu::where(function ($q) {
                    $q->whereNull('parent_id')->orWhere('parent_id', 0);
                })->with('childrenRecursive')->orderBy('kdmenu')->get()
            ));
        });
    }
}
