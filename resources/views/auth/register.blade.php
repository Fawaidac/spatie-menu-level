@extends('layouts.auth')

@section('title', 'Daftar Akun Baru')

@section('content')
    <!-- Auth Tabs (Login ⇄ Register) -->
    <div class="auth-tabs">
        <a href="{{ route('login') }}" class="auth-tab">
            Masuk
        </a>
        <a href="{{ route('register') }}" class="auth-tab is-active">
            Daftar Akun
        </a>
    </div>

    <!-- Header Section -->
    <div class="auth-form__head">
        <h1 class="auth-form__title">Daftar Akun Baru</h1>
        <p class="auth-form__sub">Bergabung dengan tim medis Tend Northside Clinic.</p>
    </div>

    <!-- Register Form -->
    <form action="{{ route('register.post') }}" method="POST" id="form-register">
        @csrf

        <div class="auth-field-group">
            <!-- Full Name -->
            <label class="auth-label" for="reg-name">
                <span>Nama Lengkap & Gelar</span>
                <div class="auth-input-wrap">
                    <svg class="ico-lead" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <input 
                        type="text" 
                        id="reg-name" 
                        name="name" 
                        class="auth-input" 
                        placeholder="contoh: dr. Budi Santoso, Sp.PD" 
                        value="{{ old('name') }}" 
                        required 
                        autocomplete="name"
                    />
                </div>
            </label>

            <!-- Email & Phone in 2 Columns on desktop -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <!-- Email -->
                <label class="auth-label" for="reg-email">
                    <span>Email Klinik</span>
                    <div class="auth-input-wrap">
                        <svg class="ico-lead" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <input 
                            type="email" 
                            id="reg-email" 
                            name="email" 
                            class="auth-input" 
                            placeholder="budi@tend.clinic" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="email"
                        />
                    </div>
                </label>

                <!-- Phone (WhatsApp) -->
                <label class="auth-label" for="reg-phone">
                    <span>Nomor WhatsApp</span>
                    <div class="auth-input-wrap">
                        <svg class="ico-lead" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <input 
                            type="tel" 
                            id="reg-phone" 
                            name="phone" 
                            class="auth-input" 
                            placeholder="0812-3456-7890" 
                            value="{{ old('phone') }}" 
                            required 
                            autocomplete="tel"
                        />
                    </div>
                </label>
            </div>

            <!-- Password & Confirmation in 2 columns -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <!-- Password -->
                <label class="auth-label" for="reg-password">
                    <span>Kata Sandi</span>
                    <div class="auth-input-wrap">
                        <svg class="ico-lead" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input 
                            type="password" 
                            id="reg-password" 
                            name="password" 
                            class="auth-input auth-input--trail" 
                            placeholder="Min 6 karakter" 
                            required 
                            autocomplete="new-password"
                            oninput="checkPwdStrength(this.value)"
                        />
                        <button type="button" class="auth-pwd-toggle" id="btn-toggle-reg-pwd" aria-label="Lihat kata sandi">
                            <svg class="ico-reg-eye" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg class="ico-reg-off" viewBox="0 0 24 24" style="display: none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                </label>

                <!-- Confirm Password -->
                <label class="auth-label" for="reg-password-confirm">
                    <span>Ulangi Kata Sandi</span>
                    <div class="auth-input-wrap">
                        <svg class="ico-lead" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        <input 
                            type="password" 
                            id="reg-password-confirm" 
                            name="password_confirmation" 
                            class="auth-input" 
                            placeholder="Ulangi kata sandi" 
                            required 
                            autocomplete="new-password"
                        />
                    </div>
                </label>
            </div>

            <!-- Password Strength Bar & Requirements Checklist (User Spec) -->
            <div class="pwd-req-container">
                <div class="pwd-req-header">
                    <span>Kekuatan Password</span>
                    <span class="pwd-req-status" id="pwd-status-text">Belum diisi</span>
                </div>

                <div class="pwd-progress-track">
                    <div class="pwd-progress-bar" id="pwd-progress-bar"></div>
                </div>

                <div class="pwd-req-card">
                    <!-- Column 1 -->
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div class="pwd-req-item" id="req-len">
                            <span class="pwd-req-icon">
                                <svg class="ico-cross" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                <svg class="ico-check" viewBox="0 0 24 24" style="display: none;"><circle cx="12" cy="12" r="10" fill="currentColor"/><path d="m9 12 2 2 4-4" stroke="#fff" stroke-width="2.2"/></svg>
                            </span>
                            <span>Min. 8 Karakter</span>
                        </div>
                        <div class="pwd-req-item" id="req-upper">
                            <span class="pwd-req-icon">
                                <svg class="ico-cross" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                <svg class="ico-check" viewBox="0 0 24 24" style="display: none;"><circle cx="12" cy="12" r="10" fill="currentColor"/><path d="m9 12 2 2 4-4" stroke="#fff" stroke-width="2.2"/></svg>
                            </span>
                            <span>Huruf Besar (A–Z)</span>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div class="pwd-req-item" id="req-lower">
                            <span class="pwd-req-icon">
                                <svg class="ico-cross" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                <svg class="ico-check" viewBox="0 0 24 24" style="display: none;"><circle cx="12" cy="12" r="10" fill="currentColor"/><path d="m9 12 2 2 4-4" stroke="#fff" stroke-width="2.2"/></svg>
                            </span>
                            <span>Huruf Kecil (a–z)</span>
                        </div>
                        <div class="pwd-req-item" id="req-symbol">
                            <span class="pwd-req-icon">
                                <svg class="ico-cross" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                <svg class="ico-check" viewBox="0 0 24 24" style="display: none;"><circle cx="12" cy="12" r="10" fill="currentColor"/><path d="m9 12 2 2 4-4" stroke="#fff" stroke-width="2.2"/></svg>
                            </span>
                            <span>Simbol Khusus (!@#$)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Terms Agreement -->
        <div class="auth-row-extra" style="margin-bottom: 24px; align-items: flex-start;">
            <label class="auth-check" style="align-items: flex-start;">
                <input type="checkbox" name="terms" id="terms" style="margin-top: 2px;" required />
                <span style="font-size: 0.8rem; line-height: 1.4;">
                    Saya menyetujui <a href="javascript:void(0)" class="auth-link">Syarat & Kebijakan Privasi</a> Rekam Medis Klinik Tend.
                </span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="auth-submit-btn" id="btn-reg-submit">
            <span>Daftar Akun Klinik</span>
            <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2.2;"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
        </button>

        <div style="text-align: center; margin-top: 18px; font-size: 0.84rem; color: var(--muted);">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="auth-link">Masuk ke sini</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    // Toggle Password Visibility
    (function () {
        var btn = document.getElementById('btn-toggle-reg-pwd');
        var input = document.getElementById('reg-password');
        var inputConfirm = document.getElementById('reg-password-confirm');
        var eye = document.querySelector('.ico-reg-eye');
        var eyeOff = document.querySelector('.ico-reg-off');

        if (btn && input) {
            btn.addEventListener('click', function () {
                var isPwd = input.type === 'password';
                input.type = isPwd ? 'text' : 'password';
                if (inputConfirm) inputConfirm.type = isPwd ? 'text' : 'password';
                if (eye && eyeOff) {
                    eye.style.display = isPwd ? 'none' : 'block';
                    eyeOff.style.display = isPwd ? 'block' : 'none';
                }
            });
        }
    })();

    // Live Password Strength & Requirements Checklist
    function checkPwdStrength(pwd) {
        var hasLen = pwd && pwd.length >= 8;
        var hasUpper = /[A-Z]/.test(pwd || '');
        var hasLower = /[a-z]/.test(pwd || '');
        var hasSymbol = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~`]/.test(pwd || '');

        updateReqItem('req-len', hasLen);
        updateReqItem('req-upper', hasUpper);
        updateReqItem('req-lower', hasLower);
        updateReqItem('req-symbol', hasSymbol);

        var score = (hasLen ? 1 : 0) + (hasUpper ? 1 : 0) + (hasLower ? 1 : 0) + (hasSymbol ? 1 : 0);

        var bar = document.getElementById('pwd-progress-bar');
        var txt = document.getElementById('pwd-status-text');

        if (!pwd || pwd.length === 0) {
            bar.style.width = '0%';
            bar.style.backgroundColor = 'var(--line)';
            txt.textContent = 'Belum diisi';
            txt.style.color = 'var(--muted)';
        } else if (score === 1) {
            bar.style.width = '25%';
            bar.style.backgroundColor = 'var(--bad)';
            txt.textContent = 'Sangat Lemah';
            txt.style.color = 'var(--bad)';
        } else if (score === 2) {
            bar.style.width = '50%';
            bar.style.backgroundColor = 'var(--warn)';
            txt.textContent = 'Lemah';
            txt.style.color = 'var(--warn)';
        } else if (score === 3) {
            bar.style.width = '75%';
            bar.style.backgroundColor = 'var(--color-brand)';
            txt.textContent = 'Sedang';
            txt.style.color = 'var(--color-brand)';
        } else if (score === 4) {
            bar.style.width = '100%';
            bar.style.backgroundColor = 'var(--good)';
            txt.textContent = 'Sangat Kuat';
            txt.style.color = 'var(--good)';
        }
    }

    function updateReqItem(id, isValid) {
        var el = document.getElementById(id);
        if (!el) return;
        el.classList.toggle('is-valid', isValid);
        var cross = el.querySelector('.ico-cross');
        var check = el.querySelector('.ico-check');
        if (cross && check) {
            cross.style.display = isValid ? 'none' : 'block';
            check.style.display = isValid ? 'block' : 'none';
        }
    }
</script>
@endpush
