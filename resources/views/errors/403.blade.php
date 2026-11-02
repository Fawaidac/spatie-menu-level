@extends('errors.layout')

@section('title', '403 — Akses Ditolak')

@section('content')
    <div class="error-badge-wrapper">
        <span class="error-badge error-badge--bad">
            <svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;" aria-hidden="true">
                <circle cx="12" cy="12" r="10" />
                <line x1="4.93" y1="4.93" x2="19.07" y2="19.07" />
            </svg>
            403 · Akses Ditolak
        </span>
    </div>

    <div class="error-icon-box error-icon-box--bad">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
        </svg>
    </div>

    <div class="error-code">403</div>
    <h1 class="error-title">Akses Tidak Diizinkan</h1>

    <p class="error-desc">
        {{ $exception->getMessage() ?: 'Maaf, akun Anda tidak memiliki hak akses untuk membuka halaman atau fitur ini. Silakan hubungi Administrator SIMRS RSUD dr. Soebandi jika Anda memerlukan wewenang ini.' }}
    </p>

    <div class="error-info-box">
        <span>Halaman yang dituju:</span>
        <code>{{ request()->path() }}</code>
    </div>

    <div class="error-actions">
        @if(session()->has('user_id'))
            <a href="{{ route('dashboard.index') }}" class="error-btn error-btn--primary">
                <svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;" aria-hidden="true">
                    <path d="M3 12h4l2-5 4 10 2-5h6" />
                </svg>
                <span>Kembali ke Dashboard</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="error-btn error-btn--primary">
                <svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;" aria-hidden="true">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                    <polyline points="10 17 15 12 10 7" />
                    <line x1="15" y1="12" x2="3" y2="12" />
                </svg>
                <span>Masuk (Login)</span>
            </a>
        @endif

        <button type="button" class="error-btn error-btn--secondary" onclick="window.history.length > 1 ? window.history.back() : window.location.href='{{ url('/') }}'">
            <svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;" aria-hidden="true">
                <line x1="19" y1="12" x2="5" y2="12" />
                <polyline points="12 19 5 12 12 5" />
            </svg>
            <span>Halaman Sebelumnya</span>
        </button>
    </div>
@endsection

