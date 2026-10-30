@php
    $rolesList = (isset($roles) && $roles instanceof \Illuminate\Support\Collection) 
        ? $roles 
        : \Spatie\Permission\Models\Role::with('permissions')->withCount(['users', 'permissions'])->orderBy('name')->get();

    $permissionsList = (isset($permissions) && $permissions instanceof \Illuminate\Support\Collection)
        ? $permissions
        : \Spatie\Permission\Models\Permission::orderBy('name')->get();

    $groupsList = $permissionsList->groupBy(fn($p) => explode('.', $p->name)[0]);

    $activeRoleStats = (isset($roleStats) && is_array($roleStats) && isset($roleStats['total_roles'])) 
        ? $roleStats 
        : [
            'total_roles'       => $rolesList->count(),
            'total_users'       => $rolesList->sum('users_count'),
            'total_permissions' => $permissionsList->count(),
            'custom_roles'      => $rolesList->whereNotIn('name', ['admin', 'user'])->count(),
        ];
@endphp

<div class="mgmt-page">
    <header class="head">
        <div class="head__lead">
            <div>
                <p class="head__eyebrow">Manajemen Akses</p>
                <h1 class="head__title">Daftar <em>Role & Peran</em></h1>
            </div>
        </div>
        <div class="head__actions">
            <a href="#/role-permissions" class="btn btn--ghost">
                <svg class="ico" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <span>Matriks Permission</span>
            </a>
            <button type="button" class="btn btn--primary" onclick="openAddRoleModal()">
                <svg class="ico" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                <span>Tambah Role</span>
            </button>
        </div>
    </header>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div style="margin-bottom:16px;padding:12px 16px;background:color-mix(in srgb,var(--good) 12%,transparent);border:1px solid color-mix(in srgb,var(--good) 30%,transparent);border-radius:8px;color:var(--good);font-size:14px;">
            ✓ {{ session('success') }}
        </div>
    @endif
    @if(isset($errors) && $errors->any())
        <div style="margin-bottom:16px;padding:12px 16px;background:color-mix(in srgb,var(--bad) 12%,transparent);border:1px solid color-mix(in srgb,var(--bad) 30%,transparent);border-radius:8px;color:var(--bad);font-size:14px;">
            ✕ {{ $errors->first() }}
        </div>
    @endif

    {{-- Stats --}}
    <section class="head__stats" style="margin-bottom:24px;">
        <div class="stat">
            <div class="stat__label">
                <span class="stat__ico"><svg class="ico" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></span>
                <span>Total Role</span>
            </div>
            <div class="stat__value">
                <span>{{ $activeRoleStats['total_roles'] ?? 0 }}</span>
                <span class="badge badge--plain">Peran</span>
            </div>
        </div>
        <div class="stat">
            <div class="stat__label">
                <span class="stat__ico" style="color:var(--sky);background:color-mix(in srgb,var(--sky) var(--soft),transparent)"><svg class="ico" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></span>
                <span>Total Pengguna</span>
            </div>
            <div class="stat__value">
                <span>{{ $activeRoleStats['total_users'] ?? 0 }}</span>
                <span class="badge badge--good">Staf</span>
            </div>
        </div>
        <div class="stat">
            <div class="stat__label">
                <span class="stat__ico" style="color:var(--lilac);background:color-mix(in srgb,var(--lilac) var(--soft),transparent)"><svg class="ico" viewBox="0 0 24 24"><path d="m9 12 2 2 4-4"/><circle cx="12" cy="12" r="10"/></svg></span>
                <span>Total Permission</span>
            </div>
            <div class="stat__value">
                <span>{{ $activeRoleStats['total_permissions'] ?? 0 }}</span>
                <span class="badge badge--plain">Izin</span>
            </div>
        </div>
        <div class="stat">
            <div class="stat__label">
                <span class="stat__ico" style="color:var(--apricot);background:color-mix(in srgb,var(--apricot) var(--soft),transparent)"><svg class="ico" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></span>
                <span>Role Kustom</span>
            </div>
            <div class="stat__value">
                <span>{{ $activeRoleStats['custom_roles'] ?? 0 }}</span>
                <span class="badge badge--warn">Aktif</span>
            </div>
        </div>
    </section>

    {{-- Role Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:16px;margin-bottom:24px;">
        @forelse($rolesList as $role)
            @php
                $rolePermsJson = json_encode($role->permissions->pluck('name')->toArray());
            @endphp
            <div class="card" style="display:flex;flex-direction:column;justify-content:space-between;">
                <div>
                    <div class="card__head" style="margin-bottom:8px;">
                        <div class="card__title">
                            <span class="dot dot--{{ $role->name === 'admin' ? 'teal' : ($role->name === 'user' ? 'sky' : 'apricot') }}"></span>
                            <span style="font-size:16px;font-weight:600;">{{ ucfirst($role->name) }}</span>
                        </div>
                        @if(in_array($role->name, ['admin', 'user']))
                            <span class="badge badge--good">Sistem</span>
                        @else
                            <span class="badge badge--plain">Kustom</span>
                        @endif
                    </div>
                    <p style="color:var(--muted);font-size:13px;margin-bottom:12px;">
                        Guard: <span style="font-family:monospace;">{{ $role->guard_name }}</span>
                    </p>
                    <div style="display:flex;flex-wrap:wrap;gap:4px;margin-bottom:14px;max-height:76px;overflow-y:auto;">
                        @forelse($role->permissions as $p)
                            <span class="badge badge--plain" style="font-size:11px;font-family:monospace;">{{ $p->name }}</span>
                        @empty
                            <small style="color:var(--muted);font-style:italic;">Belum ada hak akses (unassigned)</small>
                        @endforelse
                    </div>
                </div>
                <div>
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-top:1px solid var(--line);border-bottom:1px solid var(--line);margin-bottom:14px;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <svg class="ico" viewBox="0 0 24 24" style="color:var(--muted);width:15px;height:15px"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            <span style="font-size:12.5px;color:var(--muted)">Pengguna:</span>
                            <strong style="font-size:13px;font-variant-numeric:tabular-nums">{{ $role->users_count }} Akun</strong>
                        </div>
                        <span class="tchip tchip--{{ $role->name === 'admin' ? 'teal' : 'sky' }}" style="padding:2px 8px;font-size:11.5px">
                            {{ $role->permissions_count }} Izin
                        </span>
                    </div>
                    <div style="display:flex;gap:8px;justify-content:flex-end;">
                        <button type="button" class="btn btn--xs btn--primary" onclick="openEditRoleWithPerms({{ $role->id }}, '{{ addslashes($role->name) }}', {{ $rolePermsJson }}, {{ in_array($role->name, ['admin', 'user']) ? 'true' : 'false' }})">
                            <svg class="ico" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            <span>Atur Izin & Edit</span>
                        </button>
                        @if(!in_array($role->name, ['admin', 'user']))
                            <form method="POST" action="{{ route('management.roles.destroy', $role) }}" onsubmit="return confirm('Hapus role {{ addslashes($role->name) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn--xs btn--ghost" style="color:var(--bad);" title="Hapus Role">
                                    <svg class="ico" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="card" style="text-align:center;padding:32px;color:var(--muted);">Belum ada role terdaftar.</div>
        @endforelse
    </div>
</div>

{{-- Modal Tambah Role Beserta Assign Permission --}}
<dialog id="modal-add-role" style="border:none;border-radius:12px;padding:0;max-width:580px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.3);background:var(--bg-card, #fff);color:inherit;">
    <div style="padding:24px;max-height:85vh;overflow-y:auto;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 style="margin:0;font-size:17px;font-weight:600;">Tambah Role Baru & Hak Akses</h3>
            <button type="button" onclick="document.getElementById('modal-add-role').close()" style="background:none;border:none;cursor:pointer;color:var(--muted);">
                <svg viewBox="0 0 24 24" style="width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('management.roles.store') }}">
            @csrf
            <label class="field" style="margin-bottom:18px;">
                <span class="field__label">Nama Role</span>
                <input type="text" name="name" placeholder="contoh: apoteker, kasir, perawat-jaga" required />
                <span class="field__hint">Gunakan huruf kecil (misal: apoteker)</span>
            </label>

            <div style="margin-bottom:14px;border-top:1px solid var(--line);padding-top:14px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                    <span style="font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--text);">Assign Hak Akses (Permission):</span>
                    <div style="display:flex;gap:6px;">
                        <button type="button" class="btn btn--xs btn--ghost" onclick="toggleRolePerms('add-role-perms', true)">Pilih Semua</button>
                        <button type="button" class="btn btn--xs btn--ghost" onclick="toggleRolePerms('add-role-perms', false)">Kosongkan</button>
                    </div>
                </div>

                <div id="add-role-perms" style="display:flex;flex-direction:column;gap:16px;">
                    @foreach($groupsList as $group => $perms)
                        <div style="background:var(--surface-2, rgba(0,0,0,0.02));padding:12px 14px;border-radius:8px;border:1px solid var(--line);">
                            <div style="font-size:12px;font-weight:700;color:var(--primary);margin-bottom:8px;text-transform:uppercase;">
                                Modul {{ ucfirst($group) }}
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                                @foreach($perms as $p)
                                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:12.5px;font-family:monospace;">
                                        <input type="checkbox" name="permissions[]" value="{{ $p->name }}" class="role-perm-check" style="accent-color:var(--primary);width:15px;height:15px;">
                                        <span>{{ $p->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px;border-top:1px solid var(--line);padding-top:16px;">
                <button type="button" onclick="document.getElementById('modal-add-role').close()" class="btn btn--ghost">Batal</button>
                <button type="submit" class="btn btn--primary">Simpan Role</button>
            </div>
        </form>
    </div>
</dialog>

{{-- Modal Edit Role & Assign/Unassign Permission --}}
<dialog id="modal-edit-role" style="border:none;border-radius:12px;padding:0;max-width:580px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.3);background:var(--bg-card, #fff);color:inherit;">
    <div style="padding:24px;max-height:85vh;overflow-y:auto;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 style="margin:0;font-size:17px;font-weight:600;">Edit Role & Atur Hak Akses (Assign/Unassign)</h3>
            <button type="button" onclick="document.getElementById('modal-edit-role').close()" style="background:none;border:none;cursor:pointer;color:var(--muted);">
                <svg viewBox="0 0 24 24" style="width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" id="form-edit-role" action="">
            @csrf @method('PUT')
            <label class="field" style="margin-bottom:18px;">
                <span class="field__label">Nama Role</span>
                <input type="text" name="name" id="edit-role-name" required />
                <span class="field__hint" id="edit-role-hint"></span>
            </label>

            <div style="margin-bottom:14px;border-top:1px solid var(--line);padding-top:14px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                    <span style="font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--text);">Assign / Unassign Permissions:</span>
                    <div style="display:flex;gap:6px;">
                        <button type="button" class="btn btn--xs btn--ghost" onclick="toggleRolePerms('edit-role-perms', true)">Pilih Semua</button>
                        <button type="button" class="btn btn--xs btn--ghost" onclick="toggleRolePerms('edit-role-perms', false)">Kosongkan</button>
                    </div>
                </div>

                <div id="edit-role-perms" style="display:flex;flex-direction:column;gap:16px;">
                    @foreach($groupsList as $group => $perms)
                        <div style="background:var(--surface-2, rgba(0,0,0,0.02));padding:12px 14px;border-radius:8px;border:1px solid var(--line);">
                            <div style="font-size:12px;font-weight:700;color:var(--primary);margin-bottom:8px;text-transform:uppercase;">
                                Modul {{ ucfirst($group) }}
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                                @foreach($perms as $p)
                                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:12.5px;font-family:monospace;">
                                        <input type="checkbox" name="permissions[]" value="{{ $p->name }}" id="edit-perm-{{ str_replace('.', '-', $p->name) }}" class="edit-role-perm-check" style="accent-color:var(--primary);width:15px;height:15px;">
                                        <span>{{ $p->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px;border-top:1px solid var(--line);padding-top:16px;">
                <button type="button" onclick="document.getElementById('modal-edit-role').close()" class="btn btn--ghost">Batal</button>
                <button type="submit" class="btn btn--primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</dialog>

<script>
window.openAddRoleModal = function() {
    var dialog = document.getElementById('modal-add-role');
    if (typeof dialog.showModal === 'function') {
        dialog.showModal();
    } else {
        dialog.setAttribute('open', '');
    }
};

window.openEditRoleWithPerms = function(id, name, permissions, isSystem) {
    var form = document.getElementById('form-edit-role');
    form.action = '/management/roles/' + id;
    
    var nameInput = document.getElementById('edit-role-name');
    nameInput.value = name;
    
    var hint = document.getElementById('edit-role-hint');
    if (isSystem) {
        nameInput.setAttribute('readonly', 'readonly');
        hint.textContent = 'Nama role sistem bawaan tidak dapat diubah, namun izinnya dapat di-assign / di-unassign.';
    } else {
        nameInput.removeAttribute('readonly');
        hint.textContent = 'Gunakan huruf kecil tanpa spasi.';
    }

    // Reset all checkboxes first
    document.querySelectorAll('.edit-role-perm-check').forEach(function(cb) {
        cb.checked = false;
    });

    // Check currently assigned permissions
    if (Array.isArray(permissions)) {
        permissions.forEach(function(permName) {
            var el = document.getElementById('edit-perm-' + permName.replace(/\./g, '-'));
            if (el) el.checked = true;
        });
    }

    var dialog = document.getElementById('modal-edit-role');
    if (typeof dialog.showModal === 'function') {
        dialog.showModal();
    } else {
        dialog.setAttribute('open', '');
    }
};

window.toggleRolePerms = function(containerId, checked) {
    var cont = document.getElementById(containerId);
    if (!cont) return;
    cont.querySelectorAll('input[type="checkbox"]').forEach(function(cb) {
        cb.checked = checked;
    });
};
</script>
