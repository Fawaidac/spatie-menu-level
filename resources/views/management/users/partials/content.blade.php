@php
    $usersList = (isset($users) && $users instanceof \Illuminate\Support\Collection) 
        ? $users 
        : \App\Models\User::with('level')->latest()->get();

    $levelsList = (isset($levels) && $levels instanceof \Illuminate\Support\Collection)
        ? $levels
        : \App\Models\Level::orderBy('nama')->get();

    $activeUserStats = (isset($stats) && is_array($stats) && isset($stats['total_users'])) 
        ? $stats 
        : [
            'total_users'    => \App\Models\User::count(),
            'active_users'   => \App\Models\User::whereNotNull('email_verified_at')->count(),
            'new_this_month' => \App\Models\User::whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->count(),
        ];
@endphp

<style>
/* ── Password Strength Widget ── */
.pwd-req-container {
    margin-top: 10px;
    margin-bottom: 12px;
}
.pwd-req-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 6px;
}
.pwd-req-status {
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--muted);
    transition: color 0.25s ease;
}
.pwd-progress-track {
    width: 100%;
    height: 5px;
    background: var(--line, #e2e8f0);
    border-radius: 999px;
    overflow: hidden;
    margin-bottom: 12px;
}
.pwd-progress-bar {
    height: 100%;
    width: 0%;
    border-radius: 999px;
    background: var(--line-2, #cbd5e1);
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), background-color 0.3s ease;
}
.pwd-req-card {
    background: var(--surface-2, rgba(0,0,0,0.03));
    border: 1px solid var(--line, #e2e8f0);
    border-radius: 12px;
    padding: 12px 16px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px 16px;
    transition: all 0.25s ease;
}
.pwd-req-item {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.8rem;
    color: var(--muted);
    transition: all 0.25s ease;
}
.pwd-req-item.is-valid {
    color: var(--good, #10b981);
    font-weight: 600;
}
.pwd-req-icon {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pwd-req-icon svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    stroke-width: 2.2;
    fill: none;
}
.pwd-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}
.pwd-input-wrap input {
    width: 100%;
    padding-right: 40px !important;
}
.pwd-toggle-btn {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: var(--muted);
    padding: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pwd-toggle-btn:hover {
    color: var(--text);
}
.pwd-toggle-btn svg {
    width: 18px;
    height: 18px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
}
</style>

<div class="mgmt-page">
    <header class="head">
        <div class="head__lead">
            <div>
                <p class="head__eyebrow">Manajemen Sistem</p>
                <h1 class="head__title">Daftar <em>Pengguna</em></h1>
            </div>
        </div>
        <div class="head__actions">
            <a href="{{ route('management.users.index') }}" class="btn btn--ghost">
                <svg class="ico" viewBox="0 0 24 24"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 21h5v-5"/></svg>
                <span>Muat Ulang</span>
            </a>
            <button type="button" class="btn btn--primary" onclick="openAddUserModal()">
                <svg class="ico" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                <span>Tambah Pengguna</span>
            </button>
        </div>
    </header>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div style="margin-bottom:16px; padding:12px 16px; background:color-mix(in srgb,var(--good) 12%,transparent); border:1px solid color-mix(in srgb,var(--good) 30%,transparent); border-radius:8px; color:var(--good); font-size:14px;">
            ✓ {{ session('success') }}
        </div>
    @endif
    @if(isset($errors) && $errors->any())
        <div style="margin-bottom:16px; padding:12px 16px; background:color-mix(in srgb,var(--bad) 12%,transparent); border:1px solid color-mix(in srgb,var(--bad) 30%,transparent); border-radius:8px; color:var(--bad); font-size:14px;">
            ✕ {{ $errors->first() }}
        </div>
    @endif

    {{-- Stats Cards --}}
    <section class="head__stats" style="margin-bottom: 24px;">
        <div class="stat">
            <div class="stat__label">
                <span class="stat__ico"><svg class="ico" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></span>
                <span>Total Pengguna</span>
            </div>
            <div class="stat__value">
                <span>{{ $activeUserStats['total_users'] ?? 0 }}</span>
                <span class="badge badge--plain">Akun</span>
            </div>
        </div>
        <div class="stat">
            <div class="stat__label">
                <span class="stat__ico" style="color:var(--good);background:color-mix(in srgb,var(--good) var(--soft),transparent)"><svg class="ico" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></span>
                <span>Akun Terverifikasi</span>
            </div>
            <div class="stat__value">
                <span>{{ $activeUserStats['active_users'] ?? 0 }}</span>
                <span class="badge badge--good">Aktif</span>
            </div>
        </div>
        <div class="stat">
            <div class="stat__label">
                <span class="stat__ico" style="color:var(--mint);background:color-mix(in srgb,var(--mint) var(--soft),transparent)"><svg class="ico" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 14 14"/></svg></span>
                <span>Baru Bulan Ini</span>
            </div>
            <div class="stat__value">
                <span>{{ $activeUserStats['new_this_month'] ?? 0 }}</span>
                <span class="badge badge--warn">+Baru</span>
            </div>
        </div>
    </section>

    {{-- Filter & Search --}}
    <form method="GET" action="{{ route('management.users.index') }}" class="toolbar" style="margin-bottom:18px;">
        <div class="search" style="max-width:360px;flex:1;">
            <svg class="ico" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" name="search" placeholder="Cari nama, email, atau telepon..." value="{{ request('search') }}" />
        </div>
    </form>

    {{-- User Table --}}
    <div class="card">
        <div class="card__head">
            <div class="card__title">
                <svg class="ico" viewBox="0 0 24 24" style="color:var(--primary)"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span>Daftar Akun Pengguna</span>
            </div>
            <span class="card__sub"><strong>{{ $usersList->count() }}</strong> pengguna terdaftar</span>
        </div>
        <div class="table-wrap">
            <table class="table" id="table-users">
                <thead>
                    <tr>
                        <th>PENGGUNA</th>
                        <th>LEVEL</th>
                        <th>KONTAK</th>
                        <th>BERGABUNG</th>
                        <th class="r">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usersList as $user)
                        <tr>
                            <td>
                                <div class="cell-person">
                                    <span class="av av--md av--teal">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                    <div>
                                        <b>{{ $user->name }}</b>
                                        <small>{{ $user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user->level)
                                    <span class="badge {{ $user->level->nama === 'admin' ? 'badge--primary' : 'badge--plain' }}" style="font-weight:700; text-transform:capitalize;">
                                        {{ $user->level->nama }}
                                    </span>
                                @else
                                    <span style="color:var(--muted); font-size:12px;">—</span>
                                @endif
                            </td>
                            <td>
                                <span style="font-variant-numeric:tabular-nums;color:var(--muted);font-size:13px;">{{ $user->phone ?? '-' }}</span>
                            </td>
                            <td>
                                <small style="color:var(--muted);font-size:12.5px;">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</small>
                            </td>
                            <td class="r">
                                <div style="display:inline-flex;gap:6px;">
                                    <button type="button" class="btn btn--xs btn--ghost" onclick="openEditUserModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->phone }}', '{{ $user->level_id }}')">
                                        <svg class="ico" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        <span>Edit</span>
                                    </button>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('management.users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna {{ addslashes($user->name) }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn--xs btn--ghost" style="color:var(--bad);" title="Hapus User">
                                                <svg class="ico" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align:center;padding:32px;color:var(--muted);">Tidak ada pengguna ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah User --}}
<dialog id="modal-add-user" style="border:none;border-radius:12px;padding:0;max-width:500px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.3);background:var(--bg-card, #fff);color:inherit;">
    <div style="padding:24px;max-height:85vh;overflow-y:auto;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 style="margin:0;font-size:17px;font-weight:600;">Tambah Pengguna Baru</h3>
            <button type="button" onclick="document.getElementById('modal-add-user').close()" style="background:none;border:none;cursor:pointer;color:var(--muted);">
                <svg viewBox="0 0 24 24" style="width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('management.users.store') }}">
            @csrf
            <div style="display:flex;flex-direction:column;gap:14px;">
                <label class="field">
                    <span class="field__label">Nama Lengkap</span>
                    <input type="text" name="name" placeholder="contoh: dr. Hendra Pratama" required />
                </label>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <label class="field">
                        <span class="field__label">Email</span>
                        <input type="email" name="email" placeholder="nama@tend.clinic" required />
                    </label>
                    <label class="field">
                        <span class="field__label">Nomor WhatsApp</span>
                        <input type="tel" name="phone" placeholder="081234567890" />
                    </label>
                </div>

                <label class="field">
                    <span class="field__label">Level Akses</span>
                    <select name="level_id" style="width:100%;height:38px;padding:0 10px;border-radius:8px;border:1px solid var(--line);background:var(--surface-2);color:var(--text);font-size:13.5px;">
                        <option value="">-- Tanpa Level --</option>
                        @foreach($levelsList as $lvl)
                            <option value="{{ $lvl->id }}">{{ ucfirst($lvl->nama) }}</option>
                        @endforeach
                    </select>
                </label>

                <!-- Password Field with Strength Bar -->
                <div>
                    <label class="field">
                        <span class="field__label">Kata Sandi</span>
                        <div class="pwd-input-wrap">
                            <input type="password" id="add-user-password" name="password" placeholder="Min. 8 karakter" required oninput="evaluatePasswordStrength(this.value, 'add')" />
                            <button type="button" class="pwd-toggle-btn" onclick="togglePasswordVisibility('add-user-password', this)">
                                <svg class="ico-eye-open" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="ico-eye-closed" viewBox="0 0 24 24" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                    </label>

                    {{-- Strength Meter --}}
                    <div class="pwd-req-container">
                        <div class="pwd-req-header">
                            <span>Kekuatan Password</span>
                            <span class="pwd-req-status" id="add-pwd-status-text">Belum diisi</span>
                        </div>
                        <div class="pwd-progress-track">
                            <div class="pwd-progress-bar" id="add-pwd-progress-bar"></div>
                        </div>
                        <div class="pwd-req-card">
                            <div class="pwd-req-item" id="add-req-len">
                                <span class="pwd-req-icon">
                                    <svg class="ico-cross" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                    <svg class="ico-check" viewBox="0 0 24 24" style="display:none;"><circle cx="12" cy="12" r="10" fill="currentColor"/><path d="m9 12 2 2 4-4" stroke="#fff" stroke-width="2.2"/></svg>
                                </span>
                                <span>Min. 8 Karakter</span>
                            </div>
                            <div class="pwd-req-item" id="add-req-upper">
                                <span class="pwd-req-icon">
                                    <svg class="ico-cross" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                    <svg class="ico-check" viewBox="0 0 24 24" style="display:none;"><circle cx="12" cy="12" r="10" fill="currentColor"/><path d="m9 12 2 2 4-4" stroke="#fff" stroke-width="2.2"/></svg>
                                </span>
                                <span>Huruf Besar (A–Z)</span>
                            </div>
                            <div class="pwd-req-item" id="add-req-lower">
                                <span class="pwd-req-icon">
                                    <svg class="ico-cross" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                    <svg class="ico-check" viewBox="0 0 24 24" style="display:none;"><circle cx="12" cy="12" r="10" fill="currentColor"/><path d="m9 12 2 2 4-4" stroke="#fff" stroke-width="2.2"/></svg>
                                </span>
                                <span>Huruf Kecil (a–z)</span>
                            </div>
                            <div class="pwd-req-item" id="add-req-symbol">
                                <span class="pwd-req-icon">
                                    <svg class="ico-cross" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                    <svg class="ico-check" viewBox="0 0 24 24" style="display:none;"><circle cx="12" cy="12" r="10" fill="currentColor"/><path d="m9 12 2 2 4-4" stroke="#fff" stroke-width="2.2"/></svg>
                                </span>
                                <span>Simbol Khusus (!@#$)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;border-top:1px solid var(--line);padding-top:16px;">
                <button type="button" onclick="document.getElementById('modal-add-user').close()" class="btn btn--ghost">Batal</button>
                <button type="submit" class="btn btn--primary">Simpan Pengguna</button>
            </div>
        </form>
    </div>
</dialog>

{{-- Modal Edit User --}}
<dialog id="modal-edit-user" style="border:none;border-radius:12px;padding:0;max-width:500px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.3);background:var(--bg-card, #fff);color:inherit;">
    <div style="padding:24px;max-height:85vh;overflow-y:auto;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 style="margin:0;font-size:17px;font-weight:600;">Edit Data Pengguna</h3>
            <button type="button" onclick="document.getElementById('modal-edit-user').close()" style="background:none;border:none;cursor:pointer;color:var(--muted);">
                <svg viewBox="0 0 24 24" style="width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" id="form-edit-user" action="">
            @csrf @method('PUT')
            <div style="display:flex;flex-direction:column;gap:14px;">
                <label class="field">
                    <span class="field__label">Nama Lengkap</span>
                    <input type="text" name="name" id="edit-name" required />
                </label>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <label class="field">
                        <span class="field__label">Email</span>
                        <input type="email" name="email" id="edit-email" required />
                    </label>
                    <label class="field">
                        <span class="field__label">Nomor WhatsApp</span>
                        <input type="tel" name="phone" id="edit-phone" />
                    </label>
                </div>

                <label class="field">
                    <span class="field__label">Level Akses</span>
                    <select name="level_id" id="edit-level-id" style="width:100%;height:38px;padding:0 10px;border-radius:8px;border:1px solid var(--line);background:var(--surface-2);color:var(--text);font-size:13.5px;">
                        <option value="">-- Tanpa Level --</option>
                        @foreach($levelsList as $lvl)
                            <option value="{{ $lvl->id }}">{{ ucfirst($lvl->nama) }}</option>
                        @endforeach
                    </select>
                </label>

                <!-- Optional New Password with Strength Meter -->
                <div>
                    <label class="field">
                        <span class="field__label">Kata Sandi Baru <small style="font-weight:400;color:var(--muted);">(kosongkan bila tidak diubah)</small></span>
                        <div class="pwd-input-wrap">
                            <input type="password" id="edit-user-password" name="password" placeholder="Ketik kata sandi baru jika ingin mengubah..." oninput="evaluatePasswordStrength(this.value, 'edit')" />
                            <button type="button" class="pwd-toggle-btn" onclick="togglePasswordVisibility('edit-user-password', this)">
                                <svg class="ico-eye-open" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="ico-eye-closed" viewBox="0 0 24 24" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                    </label>

                    {{-- Strength Meter --}}
                    <div class="pwd-req-container" id="edit-pwd-meter-box" style="display:none;">
                        <div class="pwd-req-header">
                            <span>Kekuatan Password</span>
                            <span class="pwd-req-status" id="edit-pwd-status-text">Belum diisi</span>
                        </div>
                        <div class="pwd-progress-track">
                            <div class="pwd-progress-bar" id="edit-pwd-progress-bar"></div>
                        </div>
                        <div class="pwd-req-card">
                            <div class="pwd-req-item" id="edit-req-len">
                                <span class="pwd-req-icon">
                                    <svg class="ico-cross" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                    <svg class="ico-check" viewBox="0 0 24 24" style="display:none;"><circle cx="12" cy="12" r="10" fill="currentColor"/><path d="m9 12 2 2 4-4" stroke="#fff" stroke-width="2.2"/></svg>
                                </span>
                                <span>Min. 8 Karakter</span>
                            </div>
                            <div class="pwd-req-item" id="edit-req-upper">
                                <span class="pwd-req-icon">
                                    <svg class="ico-cross" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                    <svg class="ico-check" viewBox="0 0 24 24" style="display:none;"><circle cx="12" cy="12" r="10" fill="currentColor"/><path d="m9 12 2 2 4-4" stroke="#fff" stroke-width="2.2"/></svg>
                                </span>
                                <span>Huruf Besar (A–Z)</span>
                            </div>
                            <div class="pwd-req-item" id="edit-req-lower">
                                <span class="pwd-req-icon">
                                    <svg class="ico-cross" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                    <svg class="ico-check" viewBox="0 0 24 24" style="display:none;"><circle cx="12" cy="12" r="10" fill="currentColor"/><path d="m9 12 2 2 4-4" stroke="#fff" stroke-width="2.2"/></svg>
                                </span>
                                <span>Huruf Kecil (a–z)</span>
                            </div>
                            <div class="pwd-req-item" id="edit-req-symbol">
                                <span class="pwd-req-icon">
                                    <svg class="ico-cross" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                    <svg class="ico-check" viewBox="0 0 24 24" style="display:none;"><circle cx="12" cy="12" r="10" fill="currentColor"/><path d="m9 12 2 2 4-4" stroke="#fff" stroke-width="2.2"/></svg>
                                </span>
                                <span>Simbol Khusus (!@#$)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;border-top:1px solid var(--line);padding-top:16px;">
                <button type="button" onclick="document.getElementById('modal-edit-user').close()" class="btn btn--ghost">Batal</button>
                <button type="submit" class="btn btn--primary">Perbarui Data Pengguna</button>
            </div>
        </form>
    </div>
</dialog>

<script>
window.openAddUserModal = function() {
    var dialog = document.getElementById('modal-add-user');
    if (typeof dialog.showModal === 'function') {
        dialog.showModal();
    } else {
        dialog.setAttribute('open', '');
    }
};

window.openEditUserModal = function(id, name, email, phone, levelId) {
    var form = document.getElementById('form-edit-user');
    form.action = '/management/users/' + id;
    document.getElementById('edit-name').value  = name;
    document.getElementById('edit-email').value = email;
    document.getElementById('edit-phone').value = phone || '';
    var lvlSelect = document.getElementById('edit-level-id');
    if (lvlSelect) {
        lvlSelect.value = levelId || '';
    }

    // Reset password field & meter
    var pwdInput = document.getElementById('edit-user-password');
    if (pwdInput) {
        pwdInput.value = '';
        var meterBox = document.getElementById('edit-pwd-meter-box');
        if (meterBox) meterBox.style.display = 'none';
    }

    var dialog = document.getElementById('modal-edit-user');
    if (typeof dialog.showModal === 'function') {
        dialog.showModal();
    } else {
        dialog.setAttribute('open', '');
    }
};

window.togglePasswordVisibility = function(inputId, btn) {
    var input = document.getElementById(inputId);
    if (!input) return;
    var isOpen = input.type === 'text';
    input.type = isOpen ? 'password' : 'text';
    var eyeOpen = btn.querySelector('.ico-eye-open');
    var eyeClosed = btn.querySelector('.ico-eye-closed');
    if (eyeOpen && eyeClosed) {
        eyeOpen.style.display = isOpen ? 'block' : 'none';
        eyeClosed.style.display = isOpen ? 'none' : 'block';
    }
};

window.evaluatePasswordStrength = function(pwd, prefix) {
    var meterBox = document.getElementById(prefix + '-pwd-meter-box');
    if (meterBox) {
        meterBox.style.display = (!pwd || pwd.length === 0) ? 'none' : 'block';
    }

    var hasLen = pwd && pwd.length >= 8;
    var hasUpper = /[A-Z]/.test(pwd || '');
    var hasLower = /[a-z]/.test(pwd || '');
    var hasSymbol = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~`]/.test(pwd || '');

    updateReqCheck(prefix + '-req-len', hasLen);
    updateReqCheck(prefix + '-req-upper', hasUpper);
    updateReqCheck(prefix + '-req-lower', hasLower);
    updateReqCheck(prefix + '-req-symbol', hasSymbol);

    var score = (hasLen ? 1 : 0) + (hasUpper ? 1 : 0) + (hasLower ? 1 : 0) + (hasSymbol ? 1 : 0);

    var bar = document.getElementById(prefix + '-pwd-progress-bar');
    var txt = document.getElementById(prefix + '-pwd-status-text');

    if (!bar || !txt) return;

    if (!pwd || pwd.length === 0) {
        bar.style.width = '0%';
        bar.style.backgroundColor = 'var(--line, #cbd5e1)';
        txt.textContent = 'Belum diisi';
        txt.style.color = 'var(--muted)';
    } else if (score === 1) {
        bar.style.width = '25%';
        bar.style.backgroundColor = 'var(--bad, #ef4444)';
        txt.textContent = 'Sangat Lemah';
        txt.style.color = 'var(--bad, #ef4444)';
    } else if (score === 2) {
        bar.style.width = '50%';
        bar.style.backgroundColor = 'var(--warn, #f59e0b)';
        txt.textContent = 'Lemah';
        txt.style.color = 'var(--warn, #f59e0b)';
    } else if (score === 3) {
        bar.style.width = '75%';
        bar.style.backgroundColor = 'var(--color-brand, #3b82f6)';
        txt.textContent = 'Sedang';
        txt.style.color = 'var(--color-brand, #3b82f6)';
    } else if (score === 4) {
        bar.style.width = '100%';
        bar.style.backgroundColor = 'var(--good, #10b981)';
        txt.textContent = 'Sangat Kuat';
        txt.style.color = 'var(--good, #10b981)';
    }
};

function updateReqCheck(id, isValid) {
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
