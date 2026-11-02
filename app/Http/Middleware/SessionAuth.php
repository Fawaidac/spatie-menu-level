<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware pengganti 'auth' bawaan Laravel.
 * Cek session 'user_id' yang di-set oleh AuthController::login()
 * tanpa bergantung pada Laravel Auth / Eloquent User model.
 */
class SessionAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Session::has('user_id')) {
            return redirect()->route('login')->with('info', 'Silakan login terlebih dahulu.');
        }

        // Auto-logout jika session sudah lebih dari 12 jam (sesuai sistem lama: 43200 detik)
        if (time() - Session::get('loggedAt', 0) > 43200) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('info', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }

        // Perpanjang waktu login
        Session::put('loggedAt', time());

        return $next($request);
    }
}

