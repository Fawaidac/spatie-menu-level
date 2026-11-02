<?php

namespace App\Http\Controllers\Satusehat;

use App\Http\Controllers\Controller;
use App\Services\SatusehatService;

class TokenController extends Controller
{
    /**
     * Tampilkan Access Token Satu Sehat yang diambil dari auth endpoint.
     * Read-only: tidak ada generate/refresh dari UI,
     * sesuai halaman pages/api/token.php di sistem PHP native.
     */
    public function index(SatusehatService $satusehat)
    {
        $token = $satusehat->getToken();
        $expiresIn = session('satusehat_token_expires_in', 3600);

        return view('satusehat.token', compact('token', 'expiresIn'));
    }
}
