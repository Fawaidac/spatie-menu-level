@extends('layouts.app')

@section('content')
<div class="mgmt-page">
    <header class="head" style="margin-bottom: 24px;">
        <div class="head__lead">
            <div>
                <p class="head__eyebrow">Integrasi & Pengaturan Sistem</p>
                <h1 class="head__title">Kredensial <em>API Key</em></h1>
            </div>
        </div>
        <div class="head__actions">
            <button type="submit" form="form-api-key" class="btn btn--primary">
                <svg class="ico" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </header>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div style="margin-bottom:18px; padding:12px 18px; background:color-mix(in srgb,var(--good) 14%,transparent); border:1px solid color-mix(in srgb,var(--good) 32%,transparent); border-radius:10px; color:var(--good); font-size:14px; font-weight:550; display:flex; align-items:center; gap:8px;">
            <svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;"><polyline points="20 6 9 17 4 12"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Form Main --}}
    <form id="form-api-key" action="{{ route('setting.api-key.update') }}" method="POST">
        @csrf

        <div class="card" style="background: var(--surface); border: 1px solid var(--line); border-radius: 18px; box-shadow: var(--shadow-sm); overflow: hidden; margin-bottom: 24px;">
            {{-- Bagian 1: Autentikasi Kredensial --}}
            <div style="padding: 24px 28px; border-bottom: 1px solid var(--line);">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                    <span style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 8px; background: var(--primary); color: #fff;">
                        <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;stroke:#fff;"><circle cx="12" cy="12" r="3"/><path d="M12 2.8l2 2.1 2.9-.4.7 2.8 2.6 1.4-1 2.8 1 2.8-2.6 1.4-.7 2.8-2.9-.4-2 2.1-2-2.1-2.9.4-.7-2.8-2.6-1.4 1-2.8-1-2.8 2.6-1.4.7-2.8 2.9.4Z"/></svg>
                    </span>
                    <h2 style="font-size: 16px; font-weight: 700; margin: 0; color: var(--text);">Kredensial Otentikasi</h2>
                </div>
                <p style="font-size: 13px; color: var(--muted); margin: 0 0 22px 40px;">Masukkan identitas organisasi serta pasangan Client Key & Secret Key yang didapatkan dari portal SatuSehat / BPJS.</p>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; padding-left: 40px;">
                    {{-- Organization ID --}}
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">
                            Organization ID <span style="color: var(--primary);">*</span>
                        </label>
                        <div style="position: relative;">
                            <input type="text" name="organization_id" id="organization_id" value="{{ old('organization_id', $apiKey->organization_id) }}" 
                                placeholder="contoh: ORG-1000293847" required
                                style="width: 100%; height: 42px; padding: 0 42px 0 14px; border-radius: 10px; border: 1px solid var(--line-2); background: var(--surface); color: var(--text); font-family: monospace; font-size: 13.5px; outline: none; transition: all 0.2s;">
                            <button type="button" onclick="copyToClipboard('organization_id')" title="Salin Organization ID"
                                style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--muted); padding: 4px;">
                                <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            </button>
                        </div>
                        <span style="font-size: 11.5px; color: var(--muted); margin-top: 4px; display: block;">ID unik fasilitas kesehatan yang terdaftar di Kementerian Kesehatan.</span>
                    </div>

                    {{-- Client Key --}}
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">
                            Client Key <span style="color: var(--primary);">*</span>
                        </label>
                        <div style="position: relative;">
                            <input type="text" name="client_key" id="client_key" value="{{ old('client_key', $apiKey->client_key) }}" 
                                placeholder="contoh: ck_live_..." required
                                style="width: 100%; height: 42px; padding: 0 42px 0 14px; border-radius: 10px; border: 1px solid var(--line-2); background: var(--surface); color: var(--text); font-family: monospace; font-size: 13.5px; outline: none; transition: all 0.2s;">
                            <button type="button" onclick="copyToClipboard('client_key')" title="Salin Client Key"
                                style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--muted); padding: 4px;">
                                <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            </button>
                        </div>
                        <span style="font-size: 11.5px; color: var(--muted); margin-top: 4px; display: block;">Kunci identitas klien aplikasi pengirim data.</span>
                    </div>

                    {{-- Secret Key --}}
                    <div style="grid-column: 1 / -1;">
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">
                            Secret Key <span style="color: var(--primary);">*</span>
                        </label>
                        <div style="position: relative;">
                            <input type="password" name="secret_key" id="secret_key" value="{{ old('secret_key', $apiKey->secret_key) }}" 
                                placeholder="contoh: sk_live_..." required
                                style="width: 100%; height: 42px; padding: 0 80px 0 14px; border-radius: 10px; border: 1px solid var(--line-2); background: var(--surface); color: var(--text); font-family: monospace; font-size: 13.5px; outline: none; transition: all 0.2s;">
                            <div style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); display: flex; align-items: center; gap: 4px;">
                                <button type="button" onclick="toggleSecretVisibility()" title="Tampilkan/Sembunyikan"
                                    style="background: none; border: none; cursor: pointer; color: var(--muted); padding: 4px;">
                                    <svg id="eye-icon" class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                                <button type="button" onclick="copyToClipboard('secret_key')" title="Salin Secret Key"
                                    style="background: none; border: none; cursor: pointer; color: var(--muted); padding: 4px;">
                                    <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                                </button>
                            </div>
                        </div>
                        <span style="font-size: 11.5px; color: var(--muted); margin-top: 4px; display: block;">Kunci rahasia untuk proses enkripsi & verifikasi signature.</span>
                    </div>
                </div>
            </div>

            {{-- Bagian 2: Endpoint URLs --}}
            <div style="padding: 24px 28px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                    <span style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: 8px; background: rgba(184, 51, 106, 0.12); color: var(--primary);">
                        <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    </span>
                    <h2 style="font-size: 16px; font-weight: 700; margin: 0; color: var(--text);">Konfigurasi Endpoint & Server</h2>
                </div>
                <p style="font-size: 13px; color: var(--muted); margin: 0 0 22px 40px;">Konfigurasi URL layanan API untuk perolehan token, pengiriman data FHIR, dan persetujuan pasien.</p>

                <div style="display: flex; flex-direction: column; gap: 18px; padding-left: 40px;">
                    {{-- Auth URL --}}
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">
                            Auth URL (OAuth2 Token Endpoint)
                        </label>
                        <div style="position: relative;">
                            <input type="url" name="auth_url" id="auth_url" value="{{ old('auth_url', $apiKey->auth_url) }}" 
                                placeholder="https://api-satusehat.kemkes.go.id/oauth2/v1"
                                style="width: 100%; height: 42px; padding: 0 42px 0 14px; border-radius: 10px; border: 1px solid var(--line-2); background: var(--surface); color: var(--text); font-family: monospace; font-size: 13.5px; outline: none; transition: all 0.2s;">
                            <button type="button" onclick="copyToClipboard('auth_url')" title="Salin Auth URL"
                                style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--muted); padding: 4px;">
                                <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            </button>
                        </div>
                        <span style="font-size: 11.5px; color: var(--muted); margin-top: 4px; display: block;">Endpoint penghasil token autentikasi OAuth2.</span>
                    </div>

                    {{-- Base URL --}}
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">
                            Base URL (FHIR API Endpoint)
                        </label>
                        <div style="position: relative;">
                            <input type="url" name="base_url" id="base_url" value="{{ old('base_url', $apiKey->base_url) }}" 
                                placeholder="https://api-satusehat.kemkes.go.id/fhir-r4/v1"
                                style="width: 100%; height: 42px; padding: 0 42px 0 14px; border-radius: 10px; border: 1px solid var(--line-2); background: var(--surface); color: var(--text); font-family: monospace; font-size: 13.5px; outline: none; transition: all 0.2s;">
                            <button type="button" onclick="copyToClipboard('base_url')" title="Salin Base URL"
                                style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--muted); padding: 4px;">
                                <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            </button>
                        </div>
                        <span style="font-size: 11.5px; color: var(--muted); margin-top: 4px; display: block;">Host URL untuk resource FHIR (Encounter, Observation, Condition, dll).</span>
                    </div>

                    {{-- Consent URL --}}
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px;">
                            Consent URL (Layanan Persetujuan Pasien)
                        </label>
                        <div style="position: relative;">
                            <input type="url" name="consent_url" id="consent_url" value="{{ old('consent_url', $apiKey->consent_url) }}" 
                                placeholder="https://api-satusehat.kemkes.go.id/consent/v1"
                                style="width: 100%; height: 42px; padding: 0 42px 0 14px; border-radius: 10px; border: 1px solid var(--line-2); background: var(--surface); color: var(--text); font-family: monospace; font-size: 13.5px; outline: none; transition: all 0.2s;">
                            <button type="button" onclick="copyToClipboard('consent_url')" title="Salin Consent URL"
                                style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--muted); padding: 4px;">
                                <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            </button>
                        </div>
                        <span style="font-size: 11.5px; color: var(--muted); margin-top: 4px; display: block;">Layanan persetujuan pembagian rekam medis pasien.</span>
                    </div>
                </div>
            </div>

            {{-- Action Footer --}}
            <div style="padding: 16px 28px; background: rgba(0,0,0,0.015); border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 12px; align-items: center;">
                <button type="submit" class="btn btn--primary">
                    <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    <span>Simpan Kredensial</span>
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function toggleSecretVisibility() {
        const input = document.getElementById('secret_key');
        const eyeIcon = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
        } else {
            input.type = 'password';
            eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        }
    }

    function copyToClipboard(elementId) {
        const input = document.getElementById(elementId);
        if (!input) return;
        
        navigator.clipboard.writeText(input.value).then(() => {
            const toast = document.createElement('div');
            toast.style.cssText = 'position:fixed; bottom:24px; right:24px; background:var(--primary); color:#fff; padding:10px 18px; border-radius:10px; font-size:13px; font-weight:600; box-shadow:0 8px 24px rgba(0,0,0,0.18); z-index:9999;';
            toast.innerText = '✓ Kredensial tersalin ke clipboard!';
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 2000);
        }).catch(err => {
            console.error('Gagal menyalin: ', err);
        });
    }
</script>
@endpush
@endsection
