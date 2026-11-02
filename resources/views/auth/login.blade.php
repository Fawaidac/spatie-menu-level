@extends('layouts.auth')

@section('title', 'Masuk Akun')

@section('content')
    {{-- Header Section --}}
    <div class="auth-form__head">
        <h1 class="auth-form__title">Selamat Datang</h1>
        <p class="auth-form__sub">Masuk untuk mengakses Satu Sehat RSUD Soebandi.</p>
    </div>

    <form action="{{ route('login.post') }}" method="POST" id="form-login">
        @csrf

        <div class="auth-field-group">
            {{-- Username --}}
            <label class="auth-label" for="login-username">
                <span>Username</span>
                <div class="auth-input-wrap">
                    <svg class="ico-lead" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <input
                        type="text"
                        id="login-username"
                        name="username"
                        class="auth-input @error('username') is-invalid @enderror"
                        placeholder="Masukkan username..."
                        value="{{ old('username') }}"
                        required
                        autocomplete="username"
                    />
                </div>
                @error('username')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </label>

            {{-- Password --}}
            <label class="auth-label" for="login-password">
                <span>Kata Sandi</span>
                <div class="auth-input-wrap">
                    <svg class="ico-lead" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <input 
                        type="password" 
                        id="login-password" 
                        name="password" 
                        class="auth-input auth-input--trail" 
                        placeholder="Masukkan kata sandi..." 
                        value="" 
                        required 
                        autocomplete="current-password"
                    />
                    <button type="button" class="auth-pwd-toggle" id="btn-toggle-pwd" aria-label="Lihat kata sandi">
                        <svg class="ico-pwd-eye" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg class="ico-pwd-off" viewBox="0 0 24 24" style="display: none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </button>
                </div>
            </label>
        </div>

        {{-- Remember Me & Lupa Sandi --}}
        <div class="auth-row-extra">
            <label class="auth-check">
                <input type="checkbox" name="remember" id="remember" checked />
                <span>Ingat saya di perangkat ini</span>
            </label>
            <a href="javascript:void(0)" onclick="alert('Silakan hubungi Administrator untuk mereset kata sandi Anda.')" class="auth-link">
                Lupa sandi?
            </a>
        </div>

        {{-- Captcha Verification Widget --}}
        <div class="auth-captcha-card">
            <div class="auth-captcha-head">
                <span style="display: inline-flex; align-items: center; gap: 6px;">
                    <svg viewBox="0 0 24 24" style="width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <span>Verifikasi Keamanan (Captcha)</span>
                </span>
                <span class="badge badge--plain" style="font-size: 0.68rem; cursor: pointer;" onclick="refreshCaptcha()" title="Klik untuk refresh kode">Ganti Kode</span>
            </div>

            <div class="auth-captcha-row">
                <!-- Canvas Display -->
                <div class="auth-captcha-canvas-wrap" title="Klik untuk refresh kode" onclick="refreshCaptcha()">
                    <canvas id="captcha-canvas" class="auth-captcha-canvas" width="124" height="42"></canvas>
                </div>

                <!-- Refresh Button -->
                <button type="button" class="auth-captcha-refresh-btn" id="btn-refresh-captcha" onclick="refreshCaptcha()" title="Ganti kode captcha">
                    <svg viewBox="0 0 24 24"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 21h5v-5"/></svg>
                </button>

                <!-- Input Field -->
                <input 
                    type="text" 
                    id="login-captcha" 
                    name="captcha" 
                    class="auth-captcha-input" 
                    placeholder="KODE" 
                    maxlength="5" 
                    required 
                    autocomplete="off" 
                    oninput="validateCaptchaInput(this.value)"
                />
            </div>
            <div id="captcha-feedback" style="font-size: 0.73rem; color: var(--muted); margin-top: 6px; display: flex; align-items: center; gap: 4px;">
                <span>Ketik 5 karakter yang tertera pada kotak visual di atas.</span>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="auth-submit-btn" id="btn-login-submit">
            <span>Masuk ke Dashboard</span>
            <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2.2;"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>

    </form>
@endsection

@push('scripts')
<script>
    // Toggle Password Visibility
    (function () {
        var btn   = document.getElementById('btn-toggle-pwd');
        var input = document.getElementById('login-password');
        var eye   = document.querySelector('.ico-pwd-eye');
        var eyeOff = document.querySelector('.ico-pwd-off');

        if (btn && input) {
            btn.addEventListener('click', function () {
                var isPwd = input.type === 'password';
                input.type = isPwd ? 'text' : 'password';
                if (eye && eyeOff) {
                    eye.style.display = isPwd ? 'none' : 'block';
                    eyeOff.style.display = isPwd ? 'block' : 'none';
                }
            });
        }
    })();

    // ── Interactive Visual Captcha Generator ──
    var currentCaptcha = '';

    function generateCaptchaCode(len) {
        var chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        var code = '';
        for (var i = 0; i < len; i++) {
            code += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return code;
    }

    function drawCaptcha(code) {
        var canvas = document.getElementById('captcha-canvas');
        if (!canvas) return;
        var ctx = canvas.getContext('2d');
        var w = canvas.width;
        var h = canvas.height;

        // Background
        var isDark = document.documentElement.dataset.theme === 'dark';
        ctx.fillStyle = isDark ? '#1f1f23' : '#fcedf2';
        ctx.fillRect(0, 0, w, h);

        // Noise decorative lines
        for (var i = 0; i < 4; i++) {
            ctx.strokeStyle = isDark ? 'rgba(219, 112, 147, 0.35)' : 'rgba(196, 82, 122, 0.25)';
            ctx.lineWidth = 1.5;
            ctx.beginPath();
            ctx.moveTo(Math.random() * w, Math.random() * h);
            ctx.bezierCurveTo(Math.random() * w, Math.random() * h, Math.random() * w, Math.random() * h, Math.random() * w, Math.random() * h);
            ctx.stroke();
        }

        // Noise dots
        for (var j = 0; j < 30; j++) {
            ctx.fillStyle = isDark ? 'rgba(255, 255, 255, 0.15)' : 'rgba(139, 34, 82, 0.15)';
            ctx.beginPath();
            ctx.arc(Math.random() * w, Math.random() * h, 1.2, 0, Math.PI * 2);
            ctx.fill();
        }

        // Draw Characters with slight rotation
        var charColors = isDark 
            ? ['#db7093', '#74b3f0', '#5fd09a', '#f2aa5f', '#e891aa']
            : ['#8b2252', '#a83665', '#c4527a', '#7a4a5e', '#3a1224'];

        ctx.textBaseline = 'middle';
        var startX = 14;
        var step = (w - 28) / code.length;

        for (var c = 0; c < code.length; c++) {
            var char = code[c];
            var angle = (Math.random() - 0.5) * 0.4;
            var fontSize = Math.floor(Math.random() * 4) + 21; // 21-24px

            ctx.save();
            ctx.font = 'bold ' + fontSize + 'px "Geist Mono", monospace';
            ctx.fillStyle = charColors[c % charColors.length];

            var x = startX + c * step + 6;
            var y = h / 2 + (Math.random() - 0.5) * 4;

            ctx.translate(x, y);
            ctx.rotate(angle);
            ctx.fillText(char, 0, 0);
            ctx.restore();
        }
    }

    function refreshCaptcha() {
        currentCaptcha = generateCaptchaCode(5);
        drawCaptcha(currentCaptcha);

        var inp = document.getElementById('login-captcha');
        if (inp) {
            inp.value = '';
            inp.classList.remove('is-correct');
        }
        var fb = document.getElementById('captcha-feedback');
        if (fb) {
            fb.innerHTML = '<span>Ketik 5 karakter yang tertera pada kotak visual di atas.</span>';
            fb.style.color = 'var(--muted)';
        }
    }

    function validateCaptchaInput(val) {
        var inp = document.getElementById('login-captcha');
        var fb = document.getElementById('captcha-feedback');
        if (!inp || !fb) return;

        var clean = val.trim().toUpperCase();
        if (clean.length === 5) {
            if (clean === currentCaptcha) {
                inp.classList.add('is-correct');
                fb.innerHTML = '<span style="color: var(--good); font-weight: 600;">✓ Kode Captcha cocok!</span>';
            } else {
                inp.classList.remove('is-correct');
                fb.innerHTML = '<span style="color: var(--bad); font-weight: 600;">✕ Kode Captcha tidak sesuai, coba lagi.</span>';
            }
        } else {
            inp.classList.remove('is-correct');
            fb.innerHTML = '<span>Ketik 5 karakter yang tertera pada kotak visual di atas.</span>';
            fb.style.color = 'var(--muted)';
        }
    }

    // Initialize Captcha on page load and on theme change
    document.addEventListener('DOMContentLoaded', function () {
        refreshCaptcha();

        var btnTheme = document.getElementById('btn-theme-auth');
        if (btnTheme) {
            btnTheme.addEventListener('click', function () {
                setTimeout(function () {
                    drawCaptcha(currentCaptcha);
                }, 50);
            });
        }

        // Form submit validation
        var form = document.getElementById('form-login');
        if (form) {
            form.addEventListener('submit', function (e) {
                var inp = document.getElementById('login-captcha');
                if (inp && inp.value.trim().toUpperCase() !== currentCaptcha) {
                    e.preventDefault();
                    var fb = document.getElementById('captcha-feedback');
                    if (fb) {
                        fb.innerHTML = '<span style="color: var(--bad); font-weight: 700;">⚠ Harap masukkan kode captcha yang benar sebelum masuk.</span>';
                    }
                    inp.focus();
                    inp.style.borderColor = 'var(--bad)';
                    setTimeout(function () { inp.style.borderColor = ''; }, 1200);
                }
            });
        }
    });

</script>
@endpush
