@extends ('layouts.app')

@section ('content')
    <div class="mgmt-page">
        <header class="head" style="margin-bottom: 24px">
            <div class="head__lead">
                <div>
                    <p class="head__eyebrow">Sistem & Hak Akses</p>
                    <h1 class="head__title">Manajemen <em>Menu Dinamis</em></h1>
                </div>
            </div>
            <div class="head__actions">
                <a href="{{ route('setting.level.index') }}" class="btn btn--ghost">
                    <svg class="ico" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" /></svg>
                    <span>Kelola Level Akses</span>
                </a>
                <button type="button" class="btn btn--primary" onclick="openAddMenuModal()">
                    <svg class="ico" viewBox="0 0 24 24">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    <span>Tambah Menu Utama</span>
                </button>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div
                style="
                    margin-bottom: 18px;
                    padding: 12px 18px;
                    background: color-mix(in srgb, var(--good) 14%, transparent);
                    border: 1px solid color-mix(in srgb, var(--good) 32%, transparent);
                    border-radius: 10px;
                    color: var(--good);
                    font-size: 14px;
                    font-weight: 550;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                "
            >
                <svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;"><polyline points="20 6 9 17 4 12" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div
                style="
                    margin-bottom: 18px;
                    padding: 12px 18px;
                    background: color-mix(in srgb, var(--bad) 14%, transparent);
                    border: 1px solid color-mix(in srgb, var(--bad) 32%, transparent);
                    border-radius: 10px;
                    color: var(--bad);
                    font-size: 14px;
                    font-weight: 550;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                "
            >
                <svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        {{-- Stats Cards --}}
        <section class="head__stats" style="margin-bottom: 24px">
            <div class="stat">
                <div class="stat__label">
                    <span class="stat__ico"
                        <svg class="ico" viewBox="0 0 24 24">
                            <line x1="8" y1="6" x2="21" y2="6" />
                            <line x1="8" y1="12" x2="21" y2="12" />
                            <line x1="8" y1="18" x2="21" y2="18" />
                            <circle cx="4" cy="6" r="1.5" />
                            <circle cx="4" cy="12" r="1.5" />
                            <circle cx="4" cy="18" r="1.5" />
                        </svg>
                    ></span>
                    <span>Total Menu</span>
                </div>
                <div class="stat__value">
                    <span>{{ $rows->count() }}</span>
                    <span class="badge badge--plain">Item</span>
                </div>
            </div>
            <div class="stat">
                <div class="stat__label">
                    <span
                        class="stat__ico"
                        style="
                            color: var(--primary);
                            background: color-mix(in srgb, var(--primary) var(--soft), transparent);
                        "
                        ><svg class="ico" viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" /></svg
                    ></span>
                    <span>Menu Induk (Grup)</span>
                </div>
                <div class="stat__value">
                    <span>{{ $rows->where('has_children', true)->count() }}</span>
                    <span class="badge badge--good">Grup</span>
                </div>
            </div>
            <div class="stat">
                <div class="stat__label">
                    <span
                        class="stat__ico"
                        style="color: var(--mint); background: color-mix(in srgb, var(--mint) var(--soft), transparent)"
                        ><svg class="ico" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 14 14" />
                        </svg
                    ></span>
                    <span>Sub-Menu & Tautan</span>
                </div>
                <div class="stat__value">
                    <span>{{ $rows->where('has_children', false)->count() }}</span>
                    <span class="badge badge--warn">Leaf</span>
                </div>
            </div>
        </section>

        {{-- Menu Hierarchy Table --}}
        <div class="card">
            <div class="card__head">
                <div class="card__title">
                    <svg class="ico" viewBox="0 0 24 24" style="color:var(--primary)">
                        <line x1="8" y1="6" x2="21" y2="6" />
                        <line x1="8" y1="12" x2="21" y2="12" />
                        <line x1="8" y1="18" x2="21" y2="18" />
                        <circle cx="4" cy="6" r="1.5" />
                        <circle cx="4" cy="12" r="1.5" />
                        <circle cx="4" cy="18" r="1.5" />
                    </svg>
                    <span>Hierarki & Struktur Menu</span>
                </div>
                <span class="card__sub">Daftar pohon menu sidebar secara berjenjang</span>
            </div>

            <div class="table-wrap">
                <table class="table" style="width: 100%">
                    <thead>
                        <tr>
                            <th style="width: 100px">KODE</th>
                            <th>NAMA MENU</th>
                            <th>URL / ROUTE</th>
                            <th>ICON</th>
                            <th style="width: 80px; text-align: center">URUTAN</th>
                            <th style="width: 130px; text-align: center">TIPE</th>
                            <th class="r" style="width: 160px">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $menu)
                            <tr
                                class="menu-row"
                                style="background: {{ $menu->depth === 0 ? 'var(--surface)' : 'transparent' }};"
                            >
                                <td>
                                    <span
                                        class="badge {{ $menu->depth === 0 ? 'badge--primary' : 'badge--plain' }}"
                                        style="font-family: monospace; font-size: 12px; font-weight: 700"
                                    >
                                        {{ $menu->kode_menu }}
                                    </span>
                                </td>
                                <td>
                                    <div
                                        style="display:flex; align-items:center; padding-left: {{ $menu->depth * 28 }}px;"
                                    >
                                        @if ($menu->depth > 0)
                                            <span style="color: var(--muted); margin-right: 8px; font-size: 14px"
                                                >↳</span
                                            >
                                        @endif
                                        <span
                                            style="font-weight: {{ $menu->depth === 0 ? '650' : '500' }}; color: {{ $menu->depth === 0 ? 'var(--text)' : 'var(--muted)' }};"
                                        >
                                            {{ $menu->nama }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <code
                                        style="
                                            padding: 2px 6px;
                                            background: var(--surface-2);
                                            border-radius: 4px;
                                            font-size: 12px;
                                            color: var(--primary);
                                        "
                                    >
                                        {{ $menu->url }}
                                    </code>
                                </td>
                                <td>
                                    @if ($menu->icon)
                                        <span class="badge badge--plain" style="font-size: 11px">
                                            {{ $menu->icon }}
                                        </span>
                                    @else
                                        <span style="color: var(--muted); font-size: 12px">—</span>
                                    @endif
                                </td>
                                <td style="text-align: center; font-weight: 600">{{ $menu->urutan }}</td>
                                <td style="text-align: center">
                                    @if ($menu->depth > 0 || $menu->parent_id !== null)
                                        <span class="badge badge--warn" style="font-size: 11px"
                                            >Sub-Menu (Tingkat 2)</span
                                        >
                                    @elseif ($menu->has_children || $menu->url === '#')
                                        <span class="badge badge--good" style="font-size: 11px">Menu Utama (Grup)</span>
                                    @else
                                        <span class="badge badge--plain" style="font-size: 11px"
                                            >Menu Utama (Single)</span
                                        >
                                    @endif
                                </td>
                                <td class="r">
                                    <div style="display: inline-flex; align-items: center; gap: 6px">
                                        {{-- Tombol Tambah Sub-Menu (Hanya untuk Menu Utama / Tingkat 1) --}}
                                        @if ($menu->depth > 0 || $menu->parent_id !== null)
                                            <button
                                                type="button"
                                                class="ibtn ibtn--glass"
                                                title="Maksimal 2 tingkat: Sub-menu tidak dapat memiliki turunan lagi (tidak bisa membuat G11, G12, dll)"
                                                disabled
                                                style="opacity: 0.22; cursor: not-allowed; color: var(--muted)"
                                            >
                                                <svg class="ico" viewBox="0 0 24 24">
                                                    <line x1="12" y1="5" x2="12" y2="19" />
                                                    <line x1="5" y1="12" x2="19" y2="12" />
                                                </svg>
                                            </button>
                                        @else
                                            <button
                                                type="button"
                                                class="ibtn ibtn--glass"
                                                title="Tambah Sub-Menu di bawah {{ $menu->nama }}"
                                                onclick="openAddSubMenuModal('{{ $menu->id }}', '{{ addslashes($menu->nama) }}')"
                                                style="color: var(--primary)"
                                            >
                                                <svg class="ico" viewBox="0 0 24 24">
                                                    <line x1="12" y1="5" x2="12" y2="19" />
                                                    <line x1="5" y1="12" x2="19" y2="12" />
                                                </svg>
                                            </button>
                                        @endif

                                        {{-- Tombol Edit --}}
                                        <button
                                            type="button"
                                            class="ibtn ibtn--glass"
                                            title="Ubah Menu"
                                            onclick="openEditMenuModal('{{ $menu->id }}', '{{ addslashes($menu->nama) }}', '{{ addslashes($menu->url) }}', '{{ addslashes($menu->icon ?? '') }}', {{ $menu->has_children ? 'true' : 'false' }})"
                                        >
                                            <svg class="ico" viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" /></svg>
                                        </button>

                                        {{-- Tombol Hapus (dengan proteksi) --}}
                                        @if ($menu->has_children)
                                            <button
                                                type="button"
                                                class="ibtn ibtn--glass"
                                                title="Tidak dapat dihapus: menu masih memiliki sub-menu"
                                                disabled
                                                style="opacity: 0.35; cursor: not-allowed; color: var(--muted)"
                                            >
                                                <svg class="ico" viewBox="0 0 24 24">
                                                    <polyline points="3 6 5 6 21 6" />
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                </svg>
                                            </button>
                                        @else
                                            <form
                                                method="POST"
                                                action="{{ route('setting.menu.destroy', $menu->id) }}"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu {{ addslashes($menu->nama) }}?');"
                                                style="display: inline"
                                            >
                                                @csrf
                                                @method ('DELETE')
                                                <button
                                                    type="submit"
                                                    class="ibtn ibtn--glass"
                                                    title="Hapus Menu"
                                                    style="color: var(--bad)"
                                                >
                                                    <svg class="ico" viewBox="0 0 24 24">
                                                        <polyline points="3 6 5 6 21 6" />
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 48px; color: var(--muted)">
                                    Belum ada data menu. Silakan klik "Tambah Menu Utama" untuk mulai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH MENU (UTAMA / SUB) --}}
    <dialog
        class="modal"
        id="addMenuModal"
        style="
            max-width: 500px;
            padding: 0;
            border: none;
            border-radius: 16px;
            background: var(--surface);
            color: var(--text);
            box-shadow: var(--shadow-pop);
        "
    >
        <div style="padding: 24px">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px">
                <h2 id="addMenuModalTitle" style="font-size: 1.15rem; font-weight: 700; margin: 0">Tambah Menu Baru</h2>
                <button
                    type="button"
                    class="ibtn ibtn--glass"
                    onclick="document.getElementById('addMenuModal').close()"
                    aria-label="Tutup"
                >
                    <svg class="ico" viewBox="0 0 24 24">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('setting.menu.store') }}">
                @csrf

                {{-- Pilihan Induk: Hanya Menu Utama (Tingkat 1) yang bisa dipilih --}}
                <div style="margin-bottom: 16px">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px">
                        Tingkat Menu / Induk <span style="color: var(--bad)">*</span>
                    </label>
                    <select
                        name="parent_id"
                        id="add_parent_id"
                        onchange="onParentSelectChange(this)"
                        style="
                            width: 100%;
                            height: 40px;
                            padding: 0 12px;
                            border-radius: 8px;
                            border: 1px solid var(--line);
                            background: var(--surface-2);
                            color: var(--text);
                            font-size: 13.5px;
                        "
                    >
                        <option value="">(Tingkat 1) Menu Utama (A, B, C, ...)</option>
                        @foreach ($rows->whereNull('parent_id') as $p)
                            <option value="{{ $p->id }}" data-name="{{ $p->nama }}" data-code="{{ $p->kode_menu }}">
                                ↳ Sub-Menu di bawah: {{ $p->nama }} ({{ $p->kode_menu }})
                            </option>
                        @endforeach
                    </select>
                    <small
                        id="parent_hint"
                        style="display: block; margin-top: 4px; color: var(--muted); font-size: 12px"
                    >
                        Pilih Menu Utama jika ingin membuat Sub-Menu (G1, G2, dst). Sub-menu tidak dapat memiliki
                        turunan lagi (maksimal 2 tingkat).
                    </small>
                </div>

                <div style="margin-bottom: 16px">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px"
                        >Nama Menu <span style="color: var(--bad)">*</span></label
                    >
                    <input
                        type="text"
                        name="nama"
                        id="add_nama"
                        required
                        class="input"
                        placeholder="contoh: Rekam Medis / Laboratorium"
                        style="
                            width: 100%;
                            height: 40px;
                            padding: 0 12px;
                            border-radius: 8px;
                            border: 1px solid var(--line);
                            background: var(--surface-2);
                            color: var(--text);
                        "
                    />
                </div>

                <div style="margin-bottom: 16px">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px"
                        >URL / Route</label
                    >
                    <input
                        type="text"
                        name="url"
                        id="add_url"
                        placeholder="contoh: rekam-medis atau # untuk grup"
                        value="#"
                        style="
                            width: 100%;
                            height: 40px;
                            padding: 0 12px;
                            border-radius: 8px;
                            border: 1px solid var(--line);
                            background: var(--surface-2);
                            color: var(--text);
                        "
                    />
                    <small
                        id="add_url_hint"
                        style="display: block; margin-top: 4px; color: var(--muted); font-size: 12px"
                        >Isi <code>#</code> jika menu ini berfungsi sebagai pembungkus/grup sub-menu.</small
                    >
                </div>

                <div style="margin-bottom: 24px">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px"
                        >Icon (Opsional)</label
                    >
                    <input
                        type="text"
                        name="icon"
                        id="add_icon"
                        placeholder="contoh: home, users, calendar, gear, shield, menu"
                        style="
                            width: 100%;
                            height: 40px;
                            padding: 0 12px;
                            border-radius: 8px;
                            border: 1px solid var(--line);
                            background: var(--surface-2);
                            color: var(--text);
                        "
                    />
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px">
                    <button
                        type="button"
                        class="btn btn--ghost"
                        onclick="document.getElementById('addMenuModal').close()"
                    >
                        Batal
                    </button>
                    <button type="submit" class="btn btn--primary">Simpan Menu</button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- MODAL EDIT MENU --}}
    <dialog
        class="modal"
        id="editMenuModal"
        style="
            max-width: 500px;
            padding: 0;
            border: none;
            border-radius: 16px;
            background: var(--surface);
            color: var(--text);
            box-shadow: var(--shadow-pop);
        "
    >
        <div style="padding: 24px">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px">
                <h2 style="font-size: 1.15rem; font-weight: 700; margin: 0">Ubah Data Menu</h2>
                <button
                    type="button"
                    class="ibtn ibtn--glass"
                    onclick="document.getElementById('editMenuModal').close()"
                    aria-label="Tutup"
                >
                    <svg class="ico" viewBox="0 0 24 24">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            <form id="editMenuForm" method="POST" action="">
                @csrf
                @method ('PUT')

                <div style="margin-bottom: 16px">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px"
                        >Nama Menu <span style="color: var(--bad)">*</span></label
                    >
                    <input
                        type="text"
                        name="nama"
                        id="edit_nama"
                        required
                        style="
                            width: 100%;
                            height: 40px;
                            padding: 0 12px;
                            border-radius: 8px;
                            border: 1px solid var(--line);
                            background: var(--surface-2);
                            color: var(--text);
                        "
                    />
                </div>

                <div style="margin-bottom: 16px">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px"
                        >URL / Route</label
                    >
                    <input
                        type="text"
                        name="url"
                        id="edit_url"
                        style="
                            width: 100%;
                            height: 40px;
                            padding: 0 12px;
                            border-radius: 8px;
                            border: 1px solid var(--line);
                            background: var(--surface-2);
                            color: var(--text);
                        "
                    />
                    <small
                        id="edit_url_hint"
                        style="display: block; margin-top: 4px; color: var(--muted); font-size: 12px"
                    ></small>
                </div>

                <div style="margin-bottom: 24px">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px"
                        >Icon (Opsional)</label
                    >
                    <input
                        type="text"
                        name="icon"
                        id="edit_icon"
                        style="
                            width: 100%;
                            height: 40px;
                            padding: 0 12px;
                            border-radius: 8px;
                            border: 1px solid var(--line);
                            background: var(--surface-2);
                            color: var(--text);
                        "
                    />
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px">
                    <button
                        type="button"
                        class="btn btn--ghost"
                        onclick="document.getElementById('editMenuModal').close()"
                    >
                        Batal
                    </button>
                    <button type="submit" class="btn btn--primary">Perbarui Menu</button>
                </div>
            </form>
        </div>
    </dialog>

    @push ('scripts')
        <script>
            function openAddMenuModal() {
                var sel = document.getElementById('add_parent_id');
                sel.value = '';
                document.getElementById('addMenuModalTitle').innerText = 'Tambah Menu Utama';
                onParentSelectChange(sel);
                document.getElementById('addMenuModal').showModal();
            }

            function openAddSubMenuModal(parentId, parentName) {
                var sel = document.getElementById('add_parent_id');
                sel.value = parentId;
                document.getElementById('addMenuModalTitle').innerText = 'Tambah Sub-Menu di bawah: ' + parentName;
                onParentSelectChange(sel);
                document.getElementById('addMenuModal').showModal();
            }

            function onParentSelectChange(selectEl) {
                var urlInput = document.getElementById('add_url');
                var hint = document.getElementById('add_url_hint');

                if (selectEl.value) {
                    // Sub-menu terpilih
                    urlInput.placeholder = 'contoh: setting/menu atau jadwal/harian';
                    if (urlInput.value === '#') urlInput.value = '';
                    hint.innerHTML = 'Isi rute/URL untuk sub-menu ini (contoh: <code>rekam-medis</code>).';
                } else {
                    // Menu utama
                    urlInput.placeholder = 'contoh: rekam-medis atau # untuk grup';
                    if (!urlInput.value) urlInput.value = '#';
                    hint.innerHTML = 'Isi <code>#</code> jika menu ini berfungsi sebagai grup sub-menu.';
                }
            }

            function openEditMenuModal(id, nama, url, icon, hasChildren) {
                var form = document.getElementById('editMenuForm');
                form.action = '{{ url('setting/menu') }}/' + id;
                document.getElementById('edit_nama').value = nama;
                var urlInput = document.getElementById('edit_url');
                var hint = document.getElementById('edit_url_hint');

                urlInput.value = url;
                if (hasChildren) {
                    urlInput.readOnly = true;
                    hint.innerText = 'Menu ini memiliki sub-menu, URL wajib "#".';
                } else {
                    urlInput.readOnly = false;
                    hint.innerText = 'Isi URL spesifik atau "#" untuk grup.';
                }

                document.getElementById('edit_icon').value = icon;
                document.getElementById('editMenuModal').showModal();
            }
        </script>
    @endpush
@endsection
