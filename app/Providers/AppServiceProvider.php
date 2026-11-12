<?php

namespace App\Providers;

use App\Models\Menu;
use App\Support\SessionUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
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

            // Cek apakah user punya akses apapun di ms_level (logika native:
            // menu top-level non-'#' ditampilkan jika user punya setidaknya satu entri di ms_level)
            $hasAnyAccess = DB::connection('mysql')
                ->table('ms_level as ml')
                ->join(DB::raw(config('database.connections.billing.database', 'db_rsd_soebandi_billing') . '.b_ms_user as mu'), function ($join) {
                    $join->on('ml.nama_level', '=', 'mu.akses_satu_sehat')
                         ->orOn('ml.nama_level', '=', 'mu.akses');
                })
                ->where('mu.username', $sessionUser->username())
                ->exists();

            $filter = function ($menus) use (&$filter, $sessionUser, $hasAnyAccess) {
                return $menus->filter(function ($m) use (&$filter, $sessionUser, $hasAnyAccess) {
                    // Menu dengan children (parent group): tampilkan jika ada child yang lolos
                    if ($m->childrenRecursive->isNotEmpty()) {
                        $m->setRelation('childrenRecursive', $filter($m->childrenRecursive));
                        return $m->childrenRecursive->isNotEmpty();
                    }

                    // Menu top-level tanpa children dan url != '#' (leaf standalone):
                    // Di native, menu ini ditampilkan selama user punya akses apapun di ms_level
                    // (subquery COUNT tidak spesifik per menu, tapi global)
                    if ($m->url !== '#' && ((int) ($m->parent_id ?? 0)) === 0) {
                        return $hasAnyAccess;
                    }

                    // Menu child (sub-menu dalam group): cek akses per menu di ms_level
                    return $sessionUser->canMenu($m->kode_menu, 'view')
                        || $sessionUser->canMenu((string) $m->id, 'view')
                        || $sessionUser->canMenu((string) $m->url, 'view');
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
