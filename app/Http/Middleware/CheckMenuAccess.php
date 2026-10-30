<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMenuAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $kode, string $aksi = 'view')
    {
        abort_unless($request->user()?->canMenu($kode, $aksi), 403, 'Anda tidak memiliki akses.');
        return $next($request);
    }
}
