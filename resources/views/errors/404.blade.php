@extends('errors.layout')

@section('title', '404 — Halaman Tidak Ditemukan')

@section('content')
    <div class="error-badge-wrapper">
        <span class="error-badge error-badge--primary">
            <svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;" aria-hidden="true">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            404 · Tidak Ditemukan
        </span>
    </div>

    <div class="error-icon-box error-icon-box--primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="12" r="10" />
            <path d="M16 16s-1.5-2-4-2-4 2-4 2" />
            <line x1="9" y1="9" x2="9.01" y2="9" />
            <line x1="15" y1="9" x2="15.01" y2="9" />
        </svg>
    </div>

    <div class="error-code">404</div>
    <h1 class="error-title">Halaman Tidak Ditemukan</h1>

    <p class="error-desc">
        {{ $exception->getMessage() ?: 'Halaman yang Anda cari mungkin telah dipindahkan, dihapus, berganti nama, atau tautan yang Anda tuju salah ketik.' }}
    </p>

    <div class="error-info-box">
        <span>Alamat URL:</span>
        <code>/{{ ltrim(request()->path(), '/') }}</code>
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
                <span>Halaman Utama / Login</span>
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

