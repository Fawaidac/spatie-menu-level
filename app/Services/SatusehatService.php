<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class SatusehatService
{
    private const TIMEOUT = 15; // detik

    /**
     * Ambil access token Satu Sehat.
     * Jika token di session/ms_profil masih berlaku (< 60 menit), gunakan yang ada.
     * Jika sudah kadaluarsa, minta token baru dari auth_url (client_credentials).
     * Simpan hasilnya ke ms_profil dan session.
     *
     * Mirip logika includes/token.php di sistem PHP native.
     */
    public function getToken(): ?string
    {
        $token = Session::get('satusehat_access_token');
        $createdAt = Session::get('satusehat_token_created_at');

        if ($token && $createdAt && Carbon::parse($createdAt)->diffInMinutes() < 60) {
            return $token;
        }

        $profil = DB::connection('mysql')
            ->table('ms_profil')
            ->where('id', 1)
            ->first();

        if (! $profil) {
            return null;
        }

        // Cek token di ms_profil (sumber kebenaran native)
        if ($profil->token && $profil->tgl && Carbon::parse($profil->tgl)->diffInMinutes() < 60) {
            Session::put('satusehat_access_token', $profil->token);
            Session::put('satusehat_token_expires_in', 3600);
            Session::put('satusehat_token_created_at', $profil->tgl);

            return $profil->token;
        }

        // Ambil token baru dari Satu Sehat OAuth2 (client_credentials)
        try {
            $response = Http::timeout(self::TIMEOUT)
                ->post(
                    rtrim($profil->auth_url, '/') . '/accesstoken?grant_type=client_credentials',
                    [
                        'client_id'     => $profil->client_id,
                        'client_secret' => $profil->client_secret,
                    ]
                );

            if ($response->successful()) {
                $data = $response->json();
                $token = $data['access_token'] ?? null;
                $expiresIn = $data['expires_in'] ?? 3600;

                if ($token) {
                    $now = Carbon::now()->format('Y-m-d H:i:s');

                    DB::connection('mysql')->table('ms_profil')->where('id', 1)->update([
                        'token' => $token,
                        'tgl'   => $now,
                    ]);

                    Session::put('satusehat_access_token', $token);
                    Session::put('satusehat_token_expires_in', $expiresIn);
                    Session::put('satusehat_token_created_at', $now);

                    return $token;
                }
            }
        } catch (\Exception $e) {
            // Biarkan null supaya halaman menampilkan error state alih-alih loading selamanya
        }

        return null;
    }

    /**
     * Ambil data Organization dari FHIR API Satu Sehat.
     * Menggunakan organisasi_id dari ms_profil (session) dan token yang valid.
     *
     * Mirip pages/api/organization.php di sistem PHP native.
     */
    public function getOrganization(): ?array
    {
        $token = $this->getToken();

        if (! $token) {
            return null;
        }

        $profil = DB::connection('mysql')
            ->table('ms_profil')
            ->where('id', 1)
            ->first();

        if (! $profil) {
            return null;
        }

        $orgId = $profil->organisasi_id;

        try {
            $response = Http::timeout(self::TIMEOUT)
                ->withToken($token)
                ->get(rtrim($profil->base_url, '/') . '/Organization/' . $orgId);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            // Biarkan null
        }

        return null;
    }

    /**
     * Ambil data Patient dari FHIR API Satu Sehat.
     * type: 'id'  -> GET {base_url}/Patient/{query}
     * type: 'nik' -> GET {base_url}/Patient?identifier=https://fhir.kemkes.go.id/id/nik|{query}
     *
     * Mirip pages/api/patient/patient_list.php di sistem PHP native.
     */
    public function getPatient(string $type, string $query): ?array
    {
        $token = $this->getToken();

        if (! $token) {
            return null;
        }

        $profil = DB::connection('mysql')
            ->table('ms_profil')
            ->where('id', 1)
            ->first();

        if (! $profil) {
            return null;
        }

        $baseUrl = rtrim($profil->base_url, '/');

        try {
            if (strtolower($type) === 'id') {
                $response = Http::timeout(self::TIMEOUT)
                    ->withToken($token)
                    ->get($baseUrl . '/Patient/' . $query);
            } else {
                // nik
                $url = $baseUrl . '/Patient?identifier=https://fhir.kemkes.go.id/id/nik|' . $query;
                $response = Http::timeout(self::TIMEOUT)
                    ->withToken($token)
                    ->get($url);
            }

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            // Biarkan null
        }

        return null;
    }
}
