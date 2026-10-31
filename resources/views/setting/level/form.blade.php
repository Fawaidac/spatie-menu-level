@extends('layouts.app')

@section('content')
<section class="view is-active" style="display: block; opacity: 1; padding: 24px 32px 64px;">
<div class="mgmt-page">

    {{-- ── Icon Renderer Helper ── --}}
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
    @endphp

    {{-- ── Scoped Styling Selaras Tend Clinic OS ── --}}
    <style>
        .perm-matrix {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 13.5px;
        }
        .perm-matrix thead th {
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--muted);
            border-bottom: 1px solid var(--line);
            background: var(--surface);
            white-space: nowrap;
        }
        .perm-matrix thead th.c { text-align: center; }
        .perm-matrix thead th.r { text-align: right; }

        /* Group / Category Accordion Row */
        .perm-group-row {
            background: color-mix(in srgb, var(--primary) 5%, var(--surface-2));
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
            transition: background 0.15s ease;
        }
        .perm-group-row:hover {
            background: color-mix(in srgb, var(--primary) 9%, var(--surface-2));
        }
        .perm-group-cell {
            padding: 12px 16px;
            font-weight: 650;
            color: var(--text);
        }
        .perm-chevron {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 6px;
            color: var(--primary);
            transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: none;
            background: color-mix(in srgb, var(--primary) 10%, transparent);
        }
        .perm-chevron.is-collapsed {
            transform: rotate(-90deg);
        }

        /* Feature Row */
        .perm-row {
            border-bottom: 1px solid var(--line);
            transition: background 0.12s ease;
            background: var(--surface);
        }
        .perm-row:hover {
            background: color-mix(in srgb, var(--primary) 3.5%, var(--surface));
        }
        .perm-cell {
            padding: 12px 16px;
            vertical-align: middle;
        }
        .perm-cell.c { text-align: center; }

        /* Tend Chip Checkbox (Lihat, Tambah, Ubah, Hapus) */
        .perm-chip {
            display: inline-flex;
            align-items: center;
            position: relative;
            cursor: pointer;
            user-select: none;
            margin: 0;
        }
        .perm-chip input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
            pointer-events: none;
        }
        .perm-chip__box {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 550;
            color: var(--muted);
            background: var(--surface-2);
            border: 1px solid var(--line);
            transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
            min-width: 76px;
            justify-content: center;
        }
        .perm-chip:hover .perm-chip__box {
            border-color: color-mix(in srgb, var(--primary) 40%, var(--line));
            color: var(--text);
        }
        .perm-chip input:focus-visible + .perm-chip__box {
            outline: 2px solid var(--primary);
            outline-offset: 1px;
        }
        .perm-chip input:checked + .perm-chip__box {
            background: color-mix(in srgb, var(--primary) 12%, var(--surface));
            border-color: var(--primary);
            color: var(--primary);
            font-weight: 650;
            box-shadow: 0 1px 3px color-mix(in srgb, var(--primary) 15%, transparent);
        }
        .perm-chip__icon {
            width: 14px;
            height: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .perm-chip__icon svg {
            width: 100%;
            height: 100%;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
        }

        /* Checkbox Native Style */
        .tend-cb {
            accent-color: var(--primary);
            width: 17px;
            height: 17px;
            border-radius: 4px;
            cursor: pointer;
            vertical-align: middle;
        }

        /* Sub-group Tree Indent Guide */
        .tree-indent {
            display: inline-block;
            width: 22px;
            position: relative;
        }
        .tree-indent::before {
            content: '';
            position: absolute;
            left: 10px;
            top: -16px;
            bottom: 50%;
            width: 1px;
            border-left: 1.5px solid var(--line-2);
        }
        .tree-indent::after {
            content: '';
            position: absolute;
            left: 10px;
            top: 50%;
            width: 10px;
            border-top: 1.5px solid var(--line-2);
        }
    </style>

    {{-- ── Header ─────────────────────────────────────────── --}}
    <header class="head" style="margin-bottom: 24px;">
        <div class="head__lead">
            <div>
                <p class="head__eyebrow">
                    <a href="{{ route('setting.level.index') }}" style="color:var(--muted); text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                        <svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;"><polyline points="15 18 9 12 15 6"/></svg>
                        <span>Kembali ke Daftar Level</span>
                    </a>
                </p>
                <h1 class="head__title">
                    @if($level->exists)
                        Ubah Hak Akses: <em>{{ ucfirst($level->nama) }}</em>
                    @else
                        + Tambah <em>Level Baru</em>
                    @endif
                </h1>
            </div>
        </div>
        <div class="head__actions">
            <a href="{{ route('setting.level.index') }}" class="btn btn--ghost">
                <svg class="ico" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                <span>Batal</span>
            </a>
            <button type="submit" form="levelForm" class="btn btn--primary">
                <svg class="ico" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                <span>Simpan Level & Hak Akses</span>
            </button>
        </div>
    </header>

    {{-- Error --}}
    @if($errors->any())
        <div style="margin-bottom:18px; padding:12px 18px; background:color-mix(in srgb,var(--bad) 12%,transparent); border:1px solid color-mix(in srgb,var(--bad) 30%,transparent); border-radius:10px; color:var(--bad); font-size:13px; font-weight:550; display:flex; align-items:center; gap:8px;">
            <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;flex-shrink:0;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $errors->first() }}
        </div>
    @endif

    <form id="levelForm" method="POST"
          action="{{ $level->exists ? route('setting.level.update', $level->id) : route('setting.level.store') }}">
        @csrf
        @if($level->exists) @method('PUT') @endif

        {{-- ── Card 1: Nama Level Pengguna ─────────────────────────── --}}
        <div class="card" style="padding: 24px 28px; margin-bottom: 24px;">
            <div style="max-width: 580px;">
                <label for="input-nama-level" style="display:block; font-size:14px; font-weight:650; margin-bottom:8px; color:var(--text);">
                    Nama Level User <span style="color:var(--bad)">*</span>
                </label>
                <div style="position:relative; display:flex; align-items:center;">
                    <div style="position:absolute; left:14px; color:var(--muted); pointer-events:none; display:flex;">
                        <svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <input type="text"
                           id="input-nama-level"
                           name="nama"
                           value="{{ old('nama', $level->nama) }}"
                           required
                           @if($level->is_system) readonly @endif
                           placeholder="contoh: dokter, perawat, loket, apoteker"
                           style="width:100%; height:44px; padding:0 14px 0 42px; border-radius:8px; border:1px solid var(--line-2); background:{{ $level->is_system ? 'var(--well)' : 'var(--surface-2)' }}; color:var(--text); font-size:14px; outline:none; transition:border-color .15s;">
                </div>

                @if($level->is_system)
                    <div style="margin-top:10px; display:inline-flex; align-items:center; gap:6px; padding:4px 10px; border-radius:6px; background:color-mix(in srgb,var(--primary) 10%,transparent); color:var(--primary); font-size:12px; font-weight:550;">
                        <svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <span>Level sistem bawaan — nama terkunci untuk menjaga integritas, namun izin aksi dapat disesuaikan.</span>
                    </div>
                @else
                    <p style="margin-top:6px; color:var(--muted); font-size:12px;">
                        Gunakan nama peranan yang jelas dan deskriptif untuk penugasan hak akses pengguna.
                    </p>
                @endif
            </div>
        </div>

        {{-- ── Card 2: Matriks Hak Akses & Aksi ─────────────────────── --}}
        <div class="card" style="padding: 0; overflow: hidden;">
            
            {{-- Toolbar Card Header --}}
            <div style="padding: 20px 24px; border-bottom: 1px solid var(--line); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:14px; background:var(--surface);">
                <div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <div style="width:32px; height:32px; border-radius:8px; background:color-mix(in srgb,var(--primary) 12%,transparent); display:flex; align-items:center; justify-content:center; color:var(--primary);">
                            <svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div>
                            <h2 style="font-size:15px; font-weight:700; color:var(--text); margin:0;">Matriks Hak Akses Menu & Aksi</h2>
                            <p style="font-size:12px; color:var(--muted); margin:0; margin-top:2px;">Atur izin operasional (Lihat, Tambah, Ubah, Hapus) untuk setiap modul sistem.</p>
                        </div>
                    </div>
                </div>

                {{-- Tombol Pintasan Aksi Cepat --}}
                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                    <button type="button" class="btn btn--ghost" style="padding:6px 12px; font-size:12px; height:32px;" onclick="matrixExpandAll(true)">
                        <svg class="ico" viewBox="0 0 24 24" style="width:13px;height:13px;"><polyline points="6 9 12 15 18 9"/></svg>
                        <span>Buka Semua</span>
                    </button>
                    <button type="button" class="btn btn--ghost" style="padding:6px 12px; font-size:12px; height:32px;" onclick="matrixExpandAll(false)">
                        <svg class="ico" viewBox="0 0 24 24" style="width:13px;height:13px;"><polyline points="9 18 15 12 9 6"/></svg>
                        <span>Tutup Semua</span>
                    </button>
                    <button type="button" class="btn btn--ghost" style="padding:6px 12px; font-size:12px; height:32px; color:var(--good);" onclick="matrixCheckAll(true)">
                        <svg class="ico" viewBox="0 0 24 24" style="width:13px;height:13px;"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Centang Semua</span>
                    </button>
                    <button type="button" class="btn btn--ghost" style="padding:6px 12px; font-size:12px; height:32px; color:var(--bad);" onclick="matrixCheckAll(false)">
                        <svg class="ico" viewBox="0 0 24 24" style="width:13px;height:13px;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        <span>Kosongkan</span>
                    </button>
                </div>
            </div>

            {{-- ── Table Matriks Perizinan ─────────────────────────────── --}}
            <div class="table-wrap" style="border:none; margin:0;">
                <table class="perm-matrix">
                    <thead>
                        <tr>
                            <th style="min-width: 260px;">MODUL / MENU</th>
                            <th class="c" style="width: 110px;">
                                <label style="cursor:pointer; display:inline-flex; align-items:center; gap:4px;" title="Centang/Hapus semua View">
                                    <input type="checkbox" class="tend-cb" onchange="toggleAllColumn('view', this.checked)">
                                    <span>LIHAT</span>
                                </label>
                            </th>
                            <th class="c" style="width: 110px;">
                                <label style="cursor:pointer; display:inline-flex; align-items:center; gap:4px;" title="Centang/Hapus semua Add">
                                    <input type="checkbox" class="tend-cb" onchange="toggleAllColumn('add', this.checked)">
                                    <span>TAMBAH</span>
                                </label>
                            </th>
                            <th class="c" style="width: 110px;">
                                <label style="cursor:pointer; display:inline-flex; align-items:center; gap:4px;" title="Centang/Hapus semua Edit">
                                    <input type="checkbox" class="tend-cb" onchange="toggleAllColumn('edit', this.checked)">
                                    <span>UBAH</span>
                                </label>
                            </th>
                            <th class="c" style="width: 110px;">
                                <label style="cursor:pointer; display:inline-flex; align-items:center; gap:4px;" title="Centang/Hapus semua Del">
                                    <input type="checkbox" class="tend-cb" onchange="toggleAllColumn('del', this.checked)">
                                    <span>HAPUS</span>
                                </label>
                            </th>
                            <th class="c" style="width: 100px;">SEMUA</th>
                        </tr>
                    </thead>
                    <tbody id="matrixBody">
                        @php
                            $renderMatrix = function($items, $depth = 0, $parentId = null) use (&$renderMatrix, $access, $renderMenuIcon) {
                                foreach ($items as $m) {
                                    $hasChildren = $m->childrenRecursive->isNotEmpty();
                                    $menuId = $m->id;
                                    $curAcc = $access[$menuId] ?? [];
                                    $vChecked = !empty($curAcc['view']);
                                    $aChecked = !empty($curAcc['add']);
                                    $eChecked = !empty($curAcc['edit']);
                                    $dChecked = !empty($curAcc['del']);
                                    $allChecked = $vChecked && $aChecked && $eChecked && $dChecked;
                        @endphp

                            @if($hasChildren)
                                {{-- ── Baris Kategori / Grup Induk (Folder Accordion) ── --}}
                                <tr class="perm-group-row" data-group-id="{{ $menuId }}" @if($parentId) data-parent-group="{{ $parentId }}" @endif>
                                    <td colspan="5" class="perm-group-cell">
                                        <div style="display:flex; align-items:center; gap:10px; margin-left: {{ $depth * 24 }}px;">
                                            <button type="button" class="perm-chevron" onclick="toggleMatrixGroup('{{ $menuId }}', this)" title="Buka/Tutup Cabang">
                                                <svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;"><polyline points="6 9 12 15 18 9"/></svg>
                                            </button>
                                            
                                            <span style="display:inline-flex; color:var(--primary); opacity:0.85;">
                                                {!! $renderMenuIcon($m->icon) !!}
                                            </span>

                                            <span style="font-weight:700; font-size:14px; color:var(--text);">
                                                {{ $m->nama }}
                                            </span>

                                            @if($m->kode_menu)
                                                <span class="badge badge--plain" style="font-family:var(--mono); font-size:11px;">{{ $m->kode_menu }}</span>
                                            @endif

                                            <span class="badge badge--plain" style="font-size:11px; color:var(--muted);">
                                                {{ $m->childrenRecursive->count() }} Sub-fitur
                                            </span>
                                        </div>
                                    </td>
                                    <td class="perm-cell c">
                                        <label style="cursor:pointer; font-size:11.5px; font-weight:600; color:var(--primary); display:inline-flex; align-items:center; gap:4px;" title="Pilih Semua Aksi di Grup Ini">
                                            <input type="checkbox"
                                                   class="tend-cb group-all-cb"
                                                   data-target-group="{{ $menuId }}"
                                                   onchange="toggleGroupAll('{{ $menuId }}', this.checked)">
                                            <span>Grup</span>
                                        </label>
                                    </td>
                                </tr>

                                {{-- Render Sub-menu rekursif di bawah grup ini --}}
                                @php $renderMatrix($m->childrenRecursive, $depth + 1, $menuId); @endphp

                            @else
                                {{-- ── Baris Menu Leaf (Dapat Diberi Hak Akses View, Add, Edit, Del) ── --}}
                                <tr class="perm-row" data-row-id="{{ $menuId }}" @if($parentId) data-in-group="{{ $parentId }}" @endif>
                                    
                                    {{-- Kolom Info Fitur --}}
                                    <td class="perm-cell">
                                        <div style="display:flex; align-items:center; gap:10px; margin-left: {{ $depth > 0 ? ($depth * 24) : 0 }}px;">
                                            @if($depth > 0)
                                                <span class="tree-indent" aria-hidden="true"></span>
                                            @endif

                                            <div style="width:28px; height:28px; border-radius:6px; background:var(--well); display:inline-flex; align-items:center; justify-content:center; color:var(--primary); flex-shrink:0;">
                                                {!! $renderMenuIcon($m->icon) !!}
                                            </div>

                                            <div>
                                                <div style="display:flex; align-items:center; gap:6px;">
                                                    <span style="font-weight:650; color:var(--text); font-size:13.5px;">
                                                        {{ $m->nama }}
                                                    </span>
                                                    @if($m->kode_menu)
                                                        <span class="badge badge--plain" style="font-family:var(--mono); font-size:10.5px; padding:1px 5px;">{{ $m->kode_menu }}</span>
                                                    @endif
                                                </div>
                                                @if($m->url && $m->url !== '#')
                                                    <div style="font-family:var(--mono); font-size:11px; color:var(--faint); margin-top:2px;">
                                                        /{{ trim($m->url, '/') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom 1: LIHAT (View) --}}
                                    <td class="perm-cell c">
                                        <label class="perm-chip">
                                            <input type="checkbox"
                                                   name="access[{{ $menuId }}][view]"
                                                   value="1"
                                                   class="perm-cb perm-col-view perm-for-{{ $menuId }}"
                                                   id="perm_{{ $menuId }}_view"
                                                   data-menu-id="{{ $menuId }}"
                                                   data-action="view"
                                                   {{ $vChecked ? 'checked' : '' }}
                                                   onchange="onActionChange('{{ $menuId }}', 'view', this.checked)">
                                            <span class="perm-chip__box">
                                                <span class="perm-chip__icon">
                                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                                </span>
                                                <span>View</span>
                                            </span>
                                        </label>
                                    </td>

                                    {{-- Kolom 2: TAMBAH (Add) --}}
                                    <td class="perm-cell c">
                                        <label class="perm-chip">
                                            <input type="checkbox"
                                                   name="access[{{ $menuId }}][add]"
                                                   value="1"
                                                   class="perm-cb perm-col-add perm-for-{{ $menuId }}"
                                                   id="perm_{{ $menuId }}_add"
                                                   data-menu-id="{{ $menuId }}"
                                                   data-action="add"
                                                   {{ $aChecked ? 'checked' : '' }}
                                                   onchange="onActionChange('{{ $menuId }}', 'add', this.checked)">
                                            <span class="perm-chip__box">
                                                <span class="perm-chip__icon">
                                                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                                </span>
                                                <span>Add</span>
                                            </span>
                                        </label>
                                    </td>

                                    {{-- Kolom 3: UBAH (Edit) --}}
                                    <td class="perm-cell c">
                                        <label class="perm-chip">
                                            <input type="checkbox"
                                                   name="access[{{ $menuId }}][edit]"
                                                   value="1"
                                                   class="perm-cb perm-col-edit perm-for-{{ $menuId }}"
                                                   id="perm_{{ $menuId }}_edit"
                                                   data-menu-id="{{ $menuId }}"
                                                   data-action="edit"
                                                   {{ $eChecked ? 'checked' : '' }}
                                                   onchange="onActionChange('{{ $menuId }}', 'edit', this.checked)">
                                            <span class="perm-chip__box">
                                                <span class="perm-chip__icon">
                                                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                </span>
                                                <span>Edit</span>
                                            </span>
                                        </label>
                                    </td>

                                    {{-- Kolom 4: HAPUS (Del) --}}
                                    <td class="perm-cell c">
                                        <label class="perm-chip">
                                            <input type="checkbox"
                                                   name="access[{{ $menuId }}][del]"
                                                   value="1"
                                                   class="perm-cb perm-col-del perm-for-{{ $menuId }}"
                                                   id="perm_{{ $menuId }}_del"
                                                   data-menu-id="{{ $menuId }}"
                                                   data-action="del"
                                                   {{ $dChecked ? 'checked' : '' }}
                                                   onchange="onActionChange('{{ $menuId }}', 'del', this.checked)">
                                            <span class="perm-chip__box">
                                                <span class="perm-chip__icon">
                                                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                </span>
                                                <span>Del</span>
                                            </span>
                                        </label>
                                    </td>

                                    {{-- Kolom 5: CENTANG SEMUA AKSI BARIS INI --}}
                                    <td class="perm-cell c">
                                        <input type="checkbox"
                                               class="tend-cb row-all-cb"
                                               id="row_all_{{ $menuId }}"
                                               data-row-id="{{ $menuId }}"
                                               {{ $allChecked ? 'checked' : '' }}
                                               onchange="toggleRowAll('{{ $menuId }}', this.checked)"
                                               title="Centang/Hapus semua aksi untuk baris {{ $m->nama }}">
                                    </td>
                                </tr>
                            @endif

                        @php
                                }
                            };
                            $renderMatrix($menus, 0);
                        @endphp
                    </tbody>
                </table>
            </div>

            {{-- ── Form Actions Footer ─────────────────────────────── --}}
            <div style="padding: 20px 24px; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; background: var(--surface);">
                <div style="font-size: 13px; color: var(--muted); display:flex; align-items:center; gap:6px;">
                    <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;color:var(--primary);"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <span>Izin <em>Tambah</em>, <em>Ubah</em>, atau <em>Hapus</em> secara otomatis membutuhkan izin <em>Lihat</em> aktif.</span>
                </div>
                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('setting.level.index') }}" class="btn btn--ghost">Batal</a>
                    <button type="submit" class="btn btn--primary">
                        <svg class="ico" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        <span>Simpan Level & Hak Akses</span>
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>
</section>

@push('scripts')
<script>
    /* ── 1. Accordion Toggle Grup Kategori ── */
    function toggleMatrixGroup(groupId, btn) {
        var isCollapsed = btn.classList.contains('is-collapsed');
        var rows = document.querySelectorAll('tr[data-in-group="' + groupId + '"], tr[data-parent-group="' + groupId + '"]');
        
        if (isCollapsed) {
            btn.classList.remove('is-collapsed');
            rows.forEach(function(r) { r.style.display = ''; });
        } else {
            btn.classList.add('is-collapsed');
            rows.forEach(function(r) { r.style.display = 'none'; });
        }
    }

    function matrixExpandAll(expand) {
        document.querySelectorAll('.perm-chevron').forEach(function(btn) {
            if (expand) {
                btn.classList.remove('is-collapsed');
            } else {
                btn.classList.add('is-collapsed');
            }
        });
        document.querySelectorAll('tr[data-in-group], tr[data-parent-group]').forEach(function(r) {
            r.style.display = expand ? '' : 'none';
        });
    }

    /* ── 2. Master Toggle Seluruh Matriks ── */
    function matrixCheckAll(check) {
        document.querySelectorAll('#matrixBody input[type="checkbox"]').forEach(function(cb) {
            cb.checked = check;
            cb.indeterminate = false;
        });
    }

    /* ── 3. Toggle Berdasarkan Kolom (View, Add, Edit, Del) ── */
    function toggleAllColumn(action, isChecked) {
        document.querySelectorAll('.perm-col-' + action).forEach(function(cb) {
            cb.checked = isChecked;
            var menuId = cb.dataset.menuId;
            onActionChange(menuId, action, isChecked, false);
        });
        // Sinkronkan seluruh row-all checkboxes
        syncAllRowToggles();
    }

    /* ── 4. Toggle Seluruh Aksi pada Satu Baris Fitur ── */
    function toggleRowAll(menuId, isChecked) {
        var actions = ['view', 'add', 'edit', 'del'];
        actions.forEach(function(act) {
            var cb = document.getElementById('perm_' + menuId + '_' + act);
            if (cb) cb.checked = isChecked;
        });
        syncRowMaster(menuId);
    }

    /* ── 5. Toggle Seluruh Fitur di Bawah Satu Grup Kategori ── */
    function toggleGroupAll(groupId, isChecked) {
        var groupRows = document.querySelectorAll('tr[data-in-group="' + groupId + '"]');
        groupRows.forEach(function(row) {
            var menuId = row.dataset.rowId;
            if (menuId) {
                toggleRowAll(menuId, isChecked);
            }
        });
    }

    /* ── 6. Logika Relasi Aksi (Add/Edit/Del butuh View, Uncheck View matikan lainnya) ── */
    function onActionChange(menuId, action, isChecked, triggerSync = true) {
        var viewCb = document.getElementById('perm_' + menuId + '_view');
        var addCb  = document.getElementById('perm_' + menuId + '_add');
        var editCb = document.getElementById('perm_' + menuId + '_edit');
        var delCb  = document.getElementById('perm_' + menuId + '_del');

        // Aturan: Jika Add, Edit, atau Del aktif → View otomatis aktif
        if (action !== 'view' && isChecked) {
            if (viewCb) viewCb.checked = true;
        }

        // Aturan: Jika View dinonaktifkan → Add, Edit, Del otomatis nonaktif
        if (action === 'view' && !isChecked) {
            if (addCb)  addCb.checked  = false;
            if (editCb) editCb.checked = false;
            if (delCb)  delCb.checked  = false;
        }

        if (triggerSync) {
            syncRowMaster(menuId);
        }
    }

    /* ── 7. Sinkronisasi Checkbox Master Baris (Row-All) ── */
    function syncRowMaster(menuId) {
        var rowMaster = document.getElementById('row_all_' + menuId);
        if (!rowMaster) return;

        var cbs = document.querySelectorAll('.perm-for-' + menuId);
        var total = cbs.length;
        var checked = 0;
        cbs.forEach(function(c) { if (c.checked) checked++; });

        if (checked === 0) {
            rowMaster.checked = false;
            rowMaster.indeterminate = false;
        } else if (checked === total) {
            rowMaster.checked = true;
            rowMaster.indeterminate = false;
        } else {
            rowMaster.checked = false;
            rowMaster.indeterminate = true;
        }
    }

    function syncAllRowToggles() {
        document.querySelectorAll('.row-all-cb').forEach(function(rCb) {
            var menuId = rCb.dataset.rowId;
            if (menuId) syncRowMaster(menuId);
        });
    }

    // Inisialisasi awal saat halaman termuat
    document.addEventListener('DOMContentLoaded', function() {
        syncAllRowToggles();
    });
</script>
@endpush
@endsection
