<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman Login.
     * Jika sudah login (session user_id ada), langsung ke dashboard.
     */
    public function showLogin()
    {
        if (Session::has('user_id')) {
            return redirect()->route('dashboard.index');
        }

        return view('auth.login');
    }

    /**
     * Proses Login — autentikasi via DB Billing (b_ms_user),
     * sesuai sistem lama yang menggunakan MySQL PASSWORD() function.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        // 1. Autentikasi ke DB Billing — sesuai query sistem lama (login.php)
        //    Menggunakan MySQL PASSWORD() function persis seperti sistem PHP native
        $userData = DB::connection('billing')
            ->table('b_ms_user as mu')
            ->select([
                'p.nama as ppa',
                'p.ppa_id',
                'p.telp',
                'p.nama',
                'mu.id',
                'mu.username',
                'mu.userpwd',
                'mu.pegawai_id',
                'mu.group_id',
                'mu.akses',
                'mu.akses_satu_sehat',
                DB::raw("GROUP_CONCAT(pu.ms_unit_id) as unit_id"),
            ])
            ->join('b_ms_user_unit_akses as pu', 'pu.ms_user_id', '=', 'mu.id')
            ->join('b_ms_pegawai as p', 'p.id', '=', 'mu.pegawai_id')
            ->leftJoin('b_ms_reference as ref', 'ref.id', '=', 'p.ppa_id')
            ->where('mu.username', $username)
            ->whereRaw("mu.userpwd = PASSWORD(?)", [$password])
            ->where('mu.aktif', '1')
            ->groupBy(
                'p.nama',
                'p.ppa_id',
                'p.telp',
                'mu.id',
                'mu.username',
                'mu.userpwd',
                'mu.pegawai_id',
                'mu.group_id',
                'mu.akses',
                'mu.akses_satu_sehat'
            )
            ->first();

        if (! $userData) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Username atau kata sandi yang Anda masukkan salah.']);
        }

        // 2. Regenerate session untuk keamanan (cegah session fixation)
        $request->session()->regenerate();

        // 3. Ambil profil API dari DB Utama (satu_sehat) — sesuai sistem lama
        $profil = DB::connection('mysql')
            ->table('ms_profil')
            ->where('id', '1')
            ->first();

        if ($profil) {
            Session::put('client_id',     $profil->client_id);
            Session::put('client_secret', $profil->client_secret);
            Session::put('auth_url',      $profil->auth_url);
            Session::put('base_url',      $profil->base_url);
            Session::put('consent_url',   $profil->consent_url);
            Session::put('organisasi_id', $profil->organisasi_id);
        }

        // 4. Set session user — sesuai $_SESSION sistem lama (login.php)
        Session::put('user_id',          $userData->id);
        Session::put('id',               $userData->id);
        Session::put('pas',              $userData->userpwd);
        Session::put('name',             $userData->nama);
        Session::put('username',         $userData->username);
        Session::put('idname',           $userData->username);
        Session::put('unit_id',          $userData->unit_id);
        Session::put('group_id',         $userData->group_id);
        Session::put('akses',            $userData->akses);
        Session::put('akses_satu_sehat', $userData->akses_satu_sehat);
        Session::put('android',          '');
        Session::put('root',             public_path('satu_sehat/'));
        Session::put('loggedAt',         time());

        // 5. Generate server token & catat history log — sesuai sistem lama
        $server  = Str::random(8);
        $date    = now()->format('Y-m-d H:i:s');
        $remarks = 'has logged in the system at ';

        DB::connection('mysql')->table('history_log')->insert([
            'user_id' => $userData->id,
            'action'  => $remarks,
            'date'    => $date,
        ]);

        DB::connection('mysql')
            ->table('ms_user')
            ->where('username', $userData->username)
            ->update(['server' => $server]);

        Session::put('server', $server);

        return redirect()->intended(route('dashboard.index'))
            ->with('success', 'Selamat datang, ' . $userData->username . '!');
    }

    /**
     * Logout — hapus semua session dan redirect ke halaman login.
     * Catat history logout sesuai sistem lama (auth.php).
     */
    public function logout(Request $request)
    {
        // Catat history log logout jika masih ada session
        if (Session::has('user_id')) {
            try {
                DB::connection('mysql')->table('history_log')->insert([
                    'user_id' => Session::get('user_id'),
                    'action'  => 'has logged out the system at ',
                    'date'    => now()->format('Y-m-d H:i:s'),
                ]);
            } catch (\Exception $e) {
                // Jangan gagalkan logout hanya karena logging error
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah keluar dari sistem.');
    }
}
