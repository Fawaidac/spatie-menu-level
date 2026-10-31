@extends('layouts.app')

@section('content')
<div class="mgmt-page">
    <header class="head" style="margin-bottom: 24px;">
        <div class="head__lead">
            <div>
                <p class="head__eyebrow">Sistem & Hak Akses</p>
                <h1 class="head__title">Manajemen <em>Level Pengguna</em></h1>
            </div>
        </div>
        <div class="head__actions">
            <a href="{{ route('setting.menu.index') }}" class="btn btn--ghost">
                <svg class="ico" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><circle cx="4" cy="6" r="1.5"/><circle cx="4" cy="12" r="1.5"/><circle cx="4" cy="18" r="1.5"/></svg>
                <span>Kelola Menu Dinamis</span>
            </a>
            <a href="{{ route('setting.level.create') }}" class="btn btn--primary">
                <svg class="ico" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <span>Tambah Level Baru</span>
            </a>
        </div>
    </header>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div style="margin-bottom:18px; padding:12px 18px; background:color-mix(in srgb,var(--good) 14%,transparent); border:1px solid color-mix(in srgb,var(--good) 32%,transparent); border-radius:10px; color:var(--good); font-size:14px; font-weight:550; display:flex; align-items:center; gap:8px;">
            <svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;"><polyline points="20 6 9 17 4 12"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div style="margin-bottom:18px; padding:12px 18px; background:color-mix(in srgb,var(--bad) 14%,transparent); border:1px solid color-mix(in srgb,var(--bad) 32%,transparent); border-radius:10px; color:var(--bad); font-size:14px; font-weight:550; display:flex; align-items:center; gap:8px;">
            <svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    {{-- Stats Cards --}}
    <section class="head__stats" style="margin-bottom: 24px;">
        <div class="stat">
            <div class="stat__label">
                <span class="stat__ico"><svg class="ico" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></span>
                <span>Total Level</span>
            </div>
            <div class="stat__value">
                <span>{{ $levels->count() }}</span>
                <span class="badge badge--plain">Peran</span>
            </div>
        </div>
        <div class="stat">
            <div class="stat__label">
                <span class="stat__ico" style="color:var(--good);background:color-mix(in srgb,var(--good) var(--soft),transparent)"><svg class="ico" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 14 14"/></svg></span>
                <span>Level Sistem Bawaan</span>
            </div>
            <div class="stat__value">
                <span>{{ $levels->where('is_system', true)->count() }}</span>
                <span class="badge badge--good">Protected</span>
            </div>
        </div>
        <div class="stat">
            <div class="stat__label">
                <span class="stat__ico" style="color:var(--mint);background:color-mix(in srgb,var(--mint) var(--soft),transparent)"><svg class="ico" viewBox="0 0 24 24"><circle cx="9" cy="8.5" r="3.5"/><path d="M3 19.5c.6-3.2 3-5 6-5s5.4 1.8 6 5"/><path d="M15.5 5.2a3.5 3.5 0 0 1 0 6.6M17.5 14.8c1.8.6 3 2.2 3.5 4.7"/></svg></span>
                <span>Level Kustom</span>
            </div>
            <div class="stat__value">
                <span>{{ $levels->where('is_system', false)->count() }}</span>
                <span class="badge badge--warn">Kustom</span>
            </div>
        </div>
    </section>

    {{-- Level Table --}}
    <div class="card">
        <div class="card__head">
            <div class="card__title">
                <svg class="ico" viewBox="0 0 24 24" style="color:var(--primary)"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span>Daftar Level & Hak Akses</span>
            </div>
            <span class="card__sub"><strong>{{ $levels->count() }}</strong> level terdaftar di sistem</span>
        </div>

        <div class="table-wrap">
            <table class="table" style="width: 100%;">
                <thead>
                    <tr>
                        <th>NAMA LEVEL</th>
                        <th>TIPE</th>
                        <th style="text-align: center;">PENGGUNA</th>
                        <th>DIBUAT</th>
                        <th class="r">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($levels as $lvl)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: color-mix(in srgb,var(--primary) 12%,transparent); display:flex; align-items:center; justify-content:center; color:var(--primary);">
                                        <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: var(--text); font-size: 14px; text-transform: capitalize;">
                                            {{ $lvl->nama }}
                                        </div>
                                        <div style="font-size: 11px; color: var(--muted);">
                                            ID: {{ $lvl->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($lvl->is_system)
                                    <span class="badge badge--good" style="font-size: 11px;">Sistem (Terkunci)</span>
                                @else
                                    <span class="badge badge--plain" style="font-size: 11px;">Kustom</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <span class="badge {{ $lvl->users_count > 0 ? 'badge--primary' : 'badge--plain' }}" style="font-size: 12px; font-weight:700;">
                                    {{ $lvl->users_count }} Pengguna
                                </span>
                            </td>
                            <td style="color: var(--muted); font-size: 13px;">
                                {{ $lvl->created_at ? $lvl->created_at->format('d M Y') : '—' }}
                            </td>
                            <td class="r">
                                <div style="display: inline-flex; align-items: center; gap: 8px;">
                                    <a href="{{ route('setting.level.edit', $lvl->id) }}" class="btn btn--ghost" style="padding: 6px 12px; font-size: 13px;">
                                        <svg class="ico" viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                                        <span>Atur Hak Akses</span>
                                    </a>

                                    @if($lvl->is_system)
                                        <button type="button" class="ibtn ibtn--glass" disabled title="Level sistem tidak dapat dihapus" style="opacity: 0.35; cursor: not-allowed; color: var(--muted);">
                                            <svg class="ico" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    @elseif($lvl->users_count > 0)
                                        <button type="button" class="ibtn ibtn--glass" disabled title="Level masih dipakai oleh pengguna" style="opacity: 0.35; cursor: not-allowed; color: var(--muted);">
                                            <svg class="ico" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    @else
                                        <form method="POST" action="{{ route('setting.level.destroy', $lvl->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus level {{ addslashes($lvl->nama) }}?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ibtn ibtn--glass" title="Hapus Level" style="color:var(--bad);">
                                                <svg class="ico" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 48px; color: var(--muted);">
                                Belum ada data level pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

