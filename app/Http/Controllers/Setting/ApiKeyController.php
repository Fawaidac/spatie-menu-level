<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    public function index()
    {
        $apiKey = ApiKey::first() ?? new ApiKey([
            'organization_id' => '',
            'client_key' => '',
            'secret_key' => '',
            'auth_url' => '',
            'base_url' => '',
            'consent_url' => '',
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

        $apiKey = ApiKey::first();
        if ($apiKey) {
            $apiKey->update($validated);
        } else {
            ApiKey::create($validated);
        }

        return redirect()->route('setting.api-key.index')
            ->with('success', 'Konfigurasi API Key berhasil diperbarui.');
    }
}

