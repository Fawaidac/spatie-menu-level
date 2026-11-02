<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ApiKeyController extends Controller
{
    /**
     * Sumber data mengikuti sistem PHP native: tabel ms_profil (id = 1)
     * di database utama (satu_sehat). Kredensial dibaca dari sana, bukan dari
     * tabel api_keys. Tampilan (view) tetap sama.
     */
    public function index()
    {
        $profil = DB::connection('mysql')
            ->table('ms_profil')
            ->where('id', 1)
            ->first();

        // Mapping kolom ms_profil -> shape yang dipakai view (ApiKey)
        $apiKey = new ApiKey([
            'organization_id' => $profil?->organisasi_id ?? '',
            'client_key'      => $profil?->client_id ?? '',
            'secret_key'      => $profil?->client_secret ?? '',
            'auth_url'        => $profil?->auth_url ?? '',
            'base_url'        => $profil?->base_url ?? '',
            'consent_url'     => $profil?->consent_url ?? '',
        ]);

        return view('setting.api-key.index', compact('apiKey'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'organization_id' => 'nullable|string|max:255',
            'client_key'      => 'nullable|string|max:255',
            'secret_key'      => 'nullable|string',
            'auth_url'        => 'nullable|url|max:255',
            'base_url'        => 'nullable|url|max:255',
            'consent_url'     => 'nullable|url|max:255',
        ]);

        // Simpan ke ms_profil (sumber data native), id = 1
        $exists = DB::connection('mysql')
            ->table('ms_profil')
            ->where('id', 1)
            ->exists();

        $data = [
            'organisasi_id'  => $validated['organization_id'] ?? null,
            'client_id'      => $validated['client_key'] ?? null,
            'client_secret'  => $validated['secret_key'] ?? null,
            'auth_url'       => $validated['auth_url'] ?? null,
            'base_url'       => $validated['base_url'] ?? null,
            'consent_url'    => $validated['consent_url'] ?? null,
        ];

        if ($exists) {
            DB::connection('mysql')
                ->table('ms_profil')
                ->where('id', 1)
                ->update($data);
        } else {
            DB::connection('mysql')
                ->table('ms_profil')
                ->insert(array_merge(['id' => 1], $data));
        }

        // Sinkronkan session agar sesuai perilaku native (login.php)
        Session::put('organisasi_id', $validated['organization_id'] ?? Session::get('organisasi_id'));
        Session::put('client_id',     $validated['client_key'] ?? Session::get('client_id'));
        Session::put('client_secret', $validated['secret_key'] ?? Session::get('client_secret'));
        Session::put('auth_url',      $validated['auth_url'] ?? Session::get('auth_url'));
        Session::put('base_url',      $validated['base_url'] ?? Session::get('base_url'));
        Session::put('consent_url',   $validated['consent_url'] ?? Session::get('consent_url'));

        return redirect()->route('setting.api-key.index')
            ->with('success', 'Konfigurasi API Key berhasil diperbarui.');
    }
}
