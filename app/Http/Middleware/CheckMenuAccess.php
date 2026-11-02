<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use App\Support\SessionUser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMenuAccess
{
    /**
     * Handle an incoming request.
     *
     * Sistem ini menggunakan session-based auth (bukan Laravel Auth / Eloquent User).
     * Hak akses diperiksa sesuai sistem lama (ms_level & b_ms_user.akses_satu_sehat / akses).
     */
    public function handle(Request $request, Closure $next, ?string $kode = null, string $aksi = 'view'): Response
    {
        $sessionUser = session_user();

        // Tamu (belum login) ditangani oleh SessionAuth middleware
        if (! $sessionUser) {
            return $next($request);
        }

        // Jika kode menu diberikan eksplisit (misal: menu.access:D1,view)
        if ($kode) {
            abort_unless($sessionUser->canMenu($kode, $aksi), 403, 'Anda tidak memiliki akses ke menu ini.');
            return $next($request);
        }

        // Resolve menu berdasarkan URL request (termasuk sub-path & alias)
        $path = trim($request->path(), '/');

        $aliases = [
            'management/users' => 'setting/user',
        ];
        if (isset($aliases[$path])) {
            $path = $aliases[$path];
        }

        $menu = Menu::where('url', $path)->first();

        if (! $menu) {
            // Cari menu dengan url terpanjang yang menjadi prefix path
            $best = null;
            foreach (Menu::all() as $candidate) {
                $url = trim((string) $candidate->url, '/');
                if ($url === '' || $url === '#') {
                    continue;
                }
                if ($path === $url || str_starts_with($path, $url . '/')) {
                    if (! $best || strlen($url) > strlen(trim((string) $best->url, '/'))) {
                        $best = $candidate;
                    }
                }
            }
            $menu = $best;
        }

        if ($menu && ! $sessionUser->canMenu($menu->kode_menu, 'view')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
