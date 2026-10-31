<?php

namespace App\Http\Controllers\Satusehat;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function index()
    {
        $apiKey = ApiKey::first();

        // Ambil atau generate mock token SatuSehat yang realistis
        $token = session('satusehat_access_token');
        $expiresIn = session('satusehat_token_expires_in', 3600);
        $tokenCreatedAt = session('satusehat_token_created_at');

        if (!$token) {
            $token = '9VoqUAdEJSqgVl1g77F2m9mgHMz2';
            
            session([
                'satusehat_access_token' => $token,
                'satusehat_token_expires_in' => 3600,
                'satusehat_token_created_at' => now()->subMinutes(12)->toIso8601String(),
            ]);
        }

        return view('satusehat.token', compact('apiKey', 'token', 'expiresIn'));
    }

    public function generate(Request $request)
    {
        // Simulasi request refresh/generate token baru dari Auth URL
        $newToken = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6InNhdHVzZWhhdC1hdXRoLWtleS0wMiJ9.' .
                    base64_encode(json_encode([
                        'iss' => 'https://api-satusehat.kemkes.go.id/oauth2/v1',
                        'iat' => time(),
                        'exp' => time() + 3600,
                        'sub' => ApiKey::first()?->organization_id ?? 'ORG-1000293847',
                        'jti' => Str::uuid()->toString(),
                    ])) . '.' . Str::random(84);

        session([
            'satusehat_access_token' => $newToken,
            'satusehat_token_expires_in' => 3600,
            'satusehat_token_created_at' => now()->toIso8601String(),
        ]);

        return redirect()->route('satusehat.token.index')
            ->with('success', 'Access Token Satu Sehat baru berhasil digenerate.');
    }
}
