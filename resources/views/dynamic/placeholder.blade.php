@extends('layouts.app')

@section('content')
@php
    $renderMenuIcon = function($icon) {
        $icon = strtolower(trim($icon ?? ''));
        return match($icon) {
            'home', 'dashboard', 'pulse' => '<svg class="ico" viewBox="0 0 24 24"><path d="M3 12h4l2-5 4 10 2-5h6"/></svg>',
            'inbox', 'whatsapp' => '<svg class="ico" viewBox="0 0 24 24"><path d="M4.5 19.5 5.6 16A8 8 0 1 1 8.6 18.8z"/><path d="M9.5 9c.3 2.3 2.2 4.4 5.2 5.5l1-1.4-1.6-1-1 .7c-.8-.4-1.6-1.2-2-2l.7-1-1-1.6z"/></svg>',
            'patients', 'users', 'user' => '<svg class="ico" viewBox="0 0 24 24"><circle cx="9" cy="8.5" r="3.5"/><path d="M3 19.5c.6-3.2 3-5 6-5s5.4 1.8 6 5"/><path d="M15.5 5.2a3.5 3.5 0 0 1 0 6.6M17.5 14.8c1.8.6 3 2.2 3.5 4.7"/></svg>',
            'schedule', 'calendar' => '<svg class="ico" viewBox="0 0 24 24"><rect x="3.5" y="5" width="17" height="15.5" rx="3"/><path d="M3.5 10h17M8 3v4M16 3v4"/></svg>',
            'campaigns', 'megaphone' => '<svg class="ico" viewBox="0 0 24 24"><path d="M4 10v4a1.5 1.5 0 0 0 1.5 1.5H7l9 4.5V4L7 8.5H5.5A1.5 1.5 0 0 0 4 10Z"/><path d="M7 15.5 8.5 20M19.5 9.5v5"/></svg>',
            'reports', 'chart' => '<svg class="ico" viewBox="0 0 24 24"><path d="M4.5 19.5h15"/><path d="M7.5 16v-4.5M12 16V7.5M16.5 16v-6.5"/></svg>',
            'settings', 'gear', 'cog' => '<svg class="ico" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M12 2.8l2 2.1 2.9-.4.7 2.8 2.6 1.4-1 2.8 1 2.8-2.6 1.4-.7 2.8-2.9-.4-2 2.1-2-2.1-2.9.4-.7-2.8-2.6-1.4 1-2.8-1-2.8 2.6-1.4.7-2.8 2.9.4Z"/></svg>',
            'shield', 'level', 'lock' => '<svg class="ico" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
            'menu', 'list' => '<svg class="ico" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><circle cx="4" cy="6" r="1.5"/><circle cx="4" cy="12" r="1.5"/><circle cx="4" cy="18" r="1.5"/></svg>',
            default => '<svg class="ico" viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>',
        };
    };

    $user = auth()->user();
    $canAdd  = $user?->canMenu($menu->kode_menu, 'add');
    $canEdit = $user?->canMenu($menu->kode_menu, 'edit');
    $canDel  = $user?->canMenu($menu->kode_menu, 'del');
@endphp

<section class="view is-active" data-view="dynamic-{{ $menu->kode_menu }}" style="display: block; opacity: 1; padding: 24px 32px 64px;">
<div class="mgmt-page">

    {{-- ── Header ─────────────────────────────────────────── --}}
    <header class="head" style="margin-bottom: 24px;">
        <div class="head__lead">
            <div>
                <p class="head__eyebrow" style="display:flex; align-items:center; gap:6px;">
                    <a href="{{ route('dashboard.index') }}" style="color:var(--muted); text-decoration:none;">Dashboard</a>
                    <span style="color:var(--faint);">/</span>
                    <span>Modul Dinamis</span>
                    <span class="badge badge--plain" style="font-family:var(--mono); font-size:11px;">{{ $menu->kode_menu }}</span>
                </p>
                <h1 class="head__title">
                    {{ $menu->nama }} <em>Modul</em>
                </h1>
            </div>
        </div>
        <div class="head__actions">
            <a href="{{ route('setting.menu.index') }}" class="btn btn--ghost">
                <svg class="ico" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                <span>Kelola Menu</span>
            </a>
            @if($canAdd)
                <button type="button" class="btn btn--primary" onclick="alert('Fitur tambah data untuk modul {{ addslashes($menu->nama) }} dapat dikembangkan sesuai kebutuhan spesifik Anda.')">
                    <svg class="ico" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    <span>+ Tambah Data Baru</span>
                </button>
            @endif
        </div>
    </header>

    {{-- ── Status Banner Card ───────────────────────────────── --}}
    <div class="card" style="padding: 24px 28px; margin-bottom: 24px; background: linear-gradient(135deg, var(--surface) 0%, color-mix(in srgb, var(--primary) 5%, var(--surface)) 100%);">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 52px; height: 52px; border-radius: 12px; background: color-mix(in srgb, var(--primary) 12%, transparent); display: flex; align-items: center; justify-content: center; color: var(--primary); flex-shrink: 0;">
                    <div style="transform: scale(1.3); display: flex;">
                        {!! $renderMenuIcon($menu->icon) !!}
                    </div>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                        <h2 style="font-size: 1.15rem; font-weight: 700; margin: 0; color: var(--text);">
                            Halaman Modul: {{ $menu->nama }}
                        </h2>
                        <span class="badge badge--good" style="font-size: 11px;">Aktif & Terhubung</span>
                    </div>
                    <p style="font-size: 13px; color: var(--muted); margin: 0;">
                        Rute URL <code>/{{ trim($menu->url, '/') }}</code> berhasil digenerate otomatis dari Menu Dinamis.
                    </p>
                </div>
            </div>

            {{-- Hak Akses User Pada Menu Ini --}}
            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <span style="font-size: 12px; font-weight: 600; color: var(--muted);">Hak Akses Anda:</span>
                <span class="badge badge--good" title="Dapat Melihat Menu">✓ Lihat (View)</span>
                <span class="badge {{ $canAdd ? 'badge--primary' : 'badge--plain' }}" style="{{ $canAdd ? '' : 'opacity:0.4' }}" title="Izin Tambah Data">
                    {{ $canAdd ? '✓' : '✕' }} Tambah (Add)
                </span>
                <span class="badge {{ $canEdit ? 'badge--primary' : 'badge--plain' }}" style="{{ $canEdit ? '' : 'opacity:0.4' }}" title="Izin Ubah Data">
                    {{ $canEdit ? '✓' : '✕' }} Ubah (Edit)
                </span>
                <span class="badge {{ $canDel ? 'badge--warn' : 'badge--plain' }}" style="{{ $canDel ? '' : 'opacity:0.4' }}" title="Izin Hapus Data">
                    {{ $canDel ? '✓' : '✕' }} Hapus (Del)
                </span>
            </div>
        </div>
    </div>

    {{-- ── Area Konten Placeholder Bersih ─────────────────────── --}}
    <div class="card" style="padding: 56px 32px; text-align: center; border: 1.5px dashed var(--line-2); background: var(--surface);">
        <div style="max-width: 500px; margin: 0 auto;">
            <div style="width: 64px; height: 64px; margin: 0 auto 20px; border-radius: 16px; background: var(--well); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                <svg class="ico" viewBox="0 0 24 24" style="width: 32px; height: 32px;">
                    <polygon points="12 2 2 7 12 12 22 7 12 2"/>
                    <polyline points="2 17 12 22 22 17"/>
                    <polyline points="2 12 12 17 22 12"/>
                </svg>
            </div>
            
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--text); margin-bottom: 8px;">
                Ruang Kerja: {{ $menu->nama }}
            </h3>
            
            <p style="font-size: 13.5px; color: var(--muted); line-height: 1.6; margin-bottom: 24px;">
                Halaman ini siap digunakan. Anda dapat menghubungkan controller khusus, tabel data rekam medis, form transaksi, ataupun komponen modul baru untuk menu ini kapan saja.
            </p>

            <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
                <a href="{{ route('setting.level.index') }}" class="btn btn--ghost" style="font-size: 13px;">
                    <svg class="ico" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <span>Konfigurasi Izin Level</span>
                </a>
                <a href="{{ route('setting.menu.index') }}" class="btn btn--ghost" style="font-size: 13px;">
                    <svg class="ico" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><circle cx="4" cy="6" r="1.5"/><circle cx="4" cy="12" r="1.5"/><circle cx="4" cy="18" r="1.5"/></svg>
                    <span>Pengaturan Menu Dinamis</span>
                </a>
            </div>
        </div>
    </div>

</div>
</section>
@endsection

