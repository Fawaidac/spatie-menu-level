@php
    $rolesList = (isset($roles) && $roles instanceof \Illuminate\Support\Collection)
        ? $roles
        : \Spatie\Permission\Models\Role::with('permissions')->withCount('permissions')->orderBy('name')->get();

    $permissionsList = (isset($permissions) && $permissions instanceof \Illuminate\Support\Collection)
        ? $permissions
        : \Spatie\Permission\Models\Permission::orderBy('name')->get();

    $groupsList = (isset($groups) && $groups instanceof \Illuminate\Support\Collection)
        ? $groups
        : $permissionsList->groupBy(fn($p) => explode('.', $p->name)[0]);
@endphp

<div class="mgmt-page">
    <header class="head">
        <div class="head__lead">
            <div>
                <p class="head__eyebrow">Manajemen Akses</p>
                <h1 class="head__title">Matriks <em>Hak Akses & Permission</em></h1>
            </div>
        </div>
        <div class="head__actions">
            <a href="#/roles" class="btn btn--ghost">
                <svg class="ico" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span>Daftar Role</span>
            </a>
            <button type="button" class="btn btn--primary" onclick="document.getElementById('modal-add-permission').showModal()">
                <svg class="ico" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                <span>Tambah Permission</span>
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

    {{-- Role Tabs --}}
    <div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap;border-bottom:1px solid var(--line);padding-bottom:12px;">
        <span style="display:flex;align-items:center;font-size:13px;font-weight:600;color:var(--muted);margin-right:8px;">Pilih Role:</span>
        @foreach($rolesList as $role)
            <button type="button"
                class="seg__btn {{ $loop->first ? 'is-active' : '' }}"
                id="tab-btn-role-{{ $role->id }}"
                onclick="switchRolePanel('role-{{ $role->id }}', this)">
                {{ ucfirst($role->name) }}
                <span class="badge badge--{{ $role->name === 'admin' ? 'good' : 'plain' }}" style="margin-left:6px;font-size:11px;">
                    {{ $role->permissions_count ?? $role->permissions->count() }}
                </span>
            </button>
        @endforeach
    </div>

    {{-- Form per Role --}}
    @foreach($rolesList as $role)
        <div id="role-{{ $role->id }}" class="role-permission-panel" style="{{ $loop->first ? '' : 'display:none;' }}">
            <form method="POST" action="{{ route('management.role-permissions.update') }}">
                @csrf
                <input type="hidden" name="role_id" value="{{ $role->id }}" />

                <div class="card">
                    <div class="card__head" style="flex-wrap:wrap;gap:12px;">
                        <div class="card__title">
                            <span class="dot dot--{{ $role->name === 'admin' ? 'teal' : 'sky' }}"></span>
                            <span>Konfigurasi Izin: <strong>{{ ucfirst($role->name) }}</strong></span>
                            @if($role->name === 'admin')
                                <span class="badge badge--good" style="margin-left:8px;">Super Admin (Akses Penuh)</span>
                            @endif
                        </div>
                        <div style="display:flex;gap:8px;">
                            <button type="button" class="btn btn--xs btn--ghost" onclick="toggleAllCheckboxes('role-{{ $role->id }}', true)">Pilih Semua</button>
                            <button type="button" class="btn btn--xs btn--ghost" onclick="toggleAllCheckboxes('role-{{ $role->id }}', false)">Kosongkan</button>
                            <button type="submit" class="btn btn--sm btn--primary">
                                <svg class="ico" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                <span>Simpan Hak Akses</span>
                            </button>
                        </div>
                    </div>

                    <div style="padding:16px 20px;">
                        @foreach($groupsList as $group => $perms)
                            <div style="margin-bottom:24px;">
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;padding-bottom:6px;border-bottom:1px solid var(--line);">
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--primary);"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                        <span style="font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">Modul {{ ucfirst($group) }}</span>
                                    </div>
                                    <span style="font-size:12px;color:var(--muted);">{{ $perms->count() }} Izin</span>
                                </div>
                                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:10px;">
                                    @foreach($perms as $perm)
                                        @php
                                            $isChecked = $role->permissions->contains('id', $perm->id);
                                        @endphp
                                        <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 14px;border:1px solid var(--line);border-radius:8px;background:var(--bg-card, #fff);transition:all .15s ease;">
                                            <label style="display:flex;align-items:center;gap:10px;cursor:pointer;flex:1;margin:0;">
                                                <input type="checkbox"
                                                    class="perm-checkbox"
                                                    name="permissions[]"
                                                    value="{{ $perm->id }}"
                                                    {{ $isChecked ? 'checked' : '' }}
                                                    style="width:16px;height:16px;accent-color:var(--primary);cursor:pointer;" />
                                                <span style="font-size:13px;font-family:monospace;font-weight:500;">{{ $perm->name }}</span>
                                            </label>
                                            <div style="display:flex;align-items:center;gap:4px;">
                                                <button type="button" class="btn btn--xs btn--ghost" style="padding:4px 6px;" title="Edit nama permission" onclick="openEditPermissionModal({{ $perm->id }}, '{{ addslashes($perm->name) }}')">
                                                    <svg class="ico" viewBox="0 0 24 24" style="width:13px;height:13px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                </button>
                                                <button type="button" class="btn btn--xs btn--ghost" style="padding:4px 6px;color:var(--bad);" title="Hapus permission" onclick="deletePermissionAction({{ $perm->id }}, '{{ addslashes($perm->name) }}')">
                                                    <svg class="ico" viewBox="0 0 24 24" style="width:13px;height:13px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
    @endforeach
</div>

{{-- Modal Tambah Permission --}}
<dialog id="modal-add-permission" style="border:none;border-radius:12px;padding:0;max-width:440px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.3);background:var(--bg-card, #fff);color:inherit;">
    <div style="padding:24px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 style="margin:0;font-size:17px;font-weight:600;">Tambah Permission Baru</h3>
            <button type="button" onclick="document.getElementById('modal-add-permission').close()" style="background:none;border:none;cursor:pointer;color:var(--muted);">
                <svg viewBox="0 0 24 24" style="width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('management.permissions.store') }}">
            @csrf
            <label class="field" style="margin-bottom:12px;">
                <span class="field__label">Nama Permission</span>
                <input type="text" name="name" placeholder="contoh: patient.export" required />
                <span class="field__hint">Format: <code>modul.aksi</code> (misal: user.create, role.edit, patient.export)</span>
            </label>
            <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px;">
                <button type="button" onclick="document.getElementById('modal-add-permission').close()" class="btn btn--ghost">Batal</button>
                <button type="submit" class="btn btn--primary">Simpan Permission</button>
            </div>
        </form>
    </div>
</dialog>

{{-- Modal Edit Permission --}}
<dialog id="modal-edit-permission" style="border:none;border-radius:12px;padding:0;max-width:440px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.3);background:var(--bg-card, #fff);color:inherit;">
    <div style="padding:24px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 style="margin:0;font-size:17px;font-weight:600;">Edit Nama Permission</h3>
            <button type="button" onclick="document.getElementById('modal-edit-permission').close()" style="background:none;border:none;cursor:pointer;color:var(--muted);">
                <svg viewBox="0 0 24 24" style="width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" id="form-edit-permission" action="">
            @csrf @method('PUT')
            <label class="field" style="margin-bottom:12px;">
                <span class="field__label">Nama Permission</span>
                <input type="text" name="name" id="edit-permission-name" required />
            </label>
            <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px;">
                <button type="button" onclick="document.getElementById('modal-edit-permission').close()" class="btn btn--ghost">Batal</button>
                <button type="submit" class="btn btn--primary">Perbarui Permission</button>
            </div>
        </form>
    </div>
</dialog>

{{-- Hidden Form for Deleting Permission --}}
<form id="form-delete-permission" method="POST" action="" style="display:none;">
    @csrf @method('DELETE')
</form>

<script>
window.switchRolePanel = function(panelId, btn) {
    document.querySelectorAll('.role-permission-panel').forEach(function(p) { p.style.display = 'none'; });
    document.querySelectorAll('.seg__btn').forEach(function(b) { b.classList.remove('is-active'); });
    var target = document.getElementById(panelId);
    if (target) target.style.display = '';
    if (btn) btn.classList.add('is-active');
};

window.toggleAllCheckboxes = function(panelId, checked) {
    var panel = document.getElementById(panelId);
    if (!panel) return;
    panel.querySelectorAll('.perm-checkbox').forEach(function(cb) {
        cb.checked = checked;
    });
};

window.openEditPermissionModal = function(id, name) {
    var form = document.getElementById('form-edit-permission');
    form.action = '/management/permissions/' + id;
    document.getElementById('edit-permission-name').value = name;
    var dialog = document.getElementById('modal-edit-permission');
    if (typeof dialog.showModal === 'function') {
        dialog.showModal();
    } else {
        dialog.setAttribute('open', '');
    }
};

window.deletePermissionAction = function(id, name) {
    if (confirm('Yakin ingin menghapus permission "' + name + '"?\nTindakan ini tidak dapat dibatalkan.')) {
        var form = document.getElementById('form-delete-permission');
        form.action = '/management/permissions/' + id;
        form.submit();
    }
};
</script>
