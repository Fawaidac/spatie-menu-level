@extends('layouts.app')

@section('content')
@php
    $pageId    = 'enc-rj';
    $title     = 'Rawat Jalan';
    $subtitle  = 'Daftar encounter kunjungan poliklinik rawat jalan terintegrasi platform Satu Sehat Kemenkes';
    $iconColor = '#1e7e34';
    $iconBg    = 'rgba(52,199,89,0.12)';
    $badgeLabel = 'Rawat Jalan';
    $routeCurrent = 'encounter.rawat-jalan';
@endphp

<section
    class="card"
    id="{{ $pageId }}"
    style="
        margin: 20px 24px 40px;
        border-radius: var(--r-card, 22px);
        border: 1px solid var(--line);
        background: var(--surface);
        box-shadow: var(--shadow);
        overflow: hidden;
        padding: 16px 20px 20px;
    "
>
    {{-- ── Header ──────────────────────────────────────── --}}
    <div
        style="
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--line);
        "
    >
        <div style="display: flex; align-items: center; gap: 12px">
            <div
                style="
                    width: 38px; height: 38px; border-radius: 12px;
                    background: {{ $iconBg }}; color: {{ $iconColor }};
                    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
                "
            >
                <svg class="ico" viewBox="0 0 24 24" style="width:20px;height:20px;stroke:{{ $iconColor }};"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <h2
                    class="card__title"
                    style="font-size:16px;font-weight:700;color:var(--text);margin:0;display:flex;align-items:center;gap:8px;"
                >
                    Encounter — {{ $title }}
                    <span class="badge" style="background:{{ $iconBg }};color:{{ $iconColor }};font-size:11px;font-weight:600;padding:2px 8px;border-radius:999px;">
                        {{ $badgeLabel }}
                    </span>
                </h2>
                <p style="font-size:12.5px;color:var(--muted);margin:2px 0 0;">{{ $subtitle }}</p>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:8px;">
            <a href="{{ route('setting.api-key.index') }}" class="btn btn--ghost"
                style="font-size:12.5px;padding:0 14px;height:36px;border-radius:10px;display:inline-flex;align-items:center;gap:6px;">
                <svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;"><path d="m21 2-2 2m-1.5 1.5 1.5 1.5-2 2-1.5-1.5M15.5 7.5 14 9l2 2 1.5-1.5M10.5 13.5a5 5 0 1 1-7-7 5 5 0 0 1 7 7Z"/></svg>
                <span>Konfigurasi API</span>
            </a>
            <button type="button" class="btn btn--primary" onclick="syncEncounterNow(this)"
                style="font-size:12.5px;padding:0 16px;height:36px;border-radius:10px;display:inline-flex;align-items:center;gap:6px;">
                <svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                <span>Sinkronisasi Sekarang</span>
            </button>
        </div>
    </div>

    {{-- ── Metrik Strip ──────────────────────────────────── --}}
    <div
        style="
            display: flex; gap: 0; margin-bottom: 18px;
            border: 1px solid var(--line); border-radius: 14px;
            overflow: hidden; background: var(--surface-2);
        "
        class="enc-metrics-strip"
    >
        <div style="flex:1;padding:14px 18px;border-right:1px solid var(--line)">
            <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;color:var(--muted);letter-spacing:.5px;margin-bottom:6px;">Total Encounter</div>
            <div style="font-size:22px;font-weight:800;color:var(--text);display:flex;align-items:baseline;gap:5px;">
                <span class="tnum">{{ number_format($summary['total_encounter']) }}</span>
                <small style="font-size:11px;font-weight:600;color:#1e7e34;">Kunjungan</small>
            </div>
        </div>
        <div style="flex:1;padding:14px 18px;border-right:1px solid var(--line)">
            <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;color:var(--muted);letter-spacing:.5px;margin-bottom:6px;">Terkirim Satu Sehat</div>
            <div style="font-size:22px;font-weight:800;color:var(--text);display:flex;align-items:baseline;gap:5px;">
                <span class="tnum">{{ number_format($summary['berhasil']) }}</span>
                <small style="font-size:11px;font-weight:600;color:#1e7e34;">Sukses</small>
            </div>
        </div>
        <div style="flex:1;padding:14px 18px;border-right:1px solid var(--line)">
            <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;color:var(--muted);letter-spacing:.5px;margin-bottom:6px;">Pending / Gagal</div>
            <div style="font-size:22px;font-weight:800;color:var(--text);display:flex;align-items:baseline;gap:5px;">
                <span class="tnum">{{ $summary['pending'] }}</span>
                <small style="font-size:11px;font-weight:500;color:var(--muted);">Rekam</small>
            </div>
        </div>
        <div style="flex:1;padding:14px 18px;">
            <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;color:var(--muted);letter-spacing:.5px;margin-bottom:6px;">Sinkronisasi Terakhir</div>
            <div style="font-size:15px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:7px;margin-top:3px;">
                <span style="width:8px;height:8px;border-radius:50%;background:#34c759;box-shadow:0 0 0 3px rgba(52,199,89,.2);flex-shrink:0;"></span>
                {{ $summary['last_sync'] }}
            </div>
        </div>
    </div>

    {{-- ── Filter Form ──────────────────────────────────── --}}
    <form method="GET" action="{{ route($routeCurrent) }}"
        style="
            background: var(--surface-2);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 18px;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 12px 16px;
            align-items: end;
        "
        class="enc-filter-form"
    >
        <div>
            <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:5px;">Tgl Periksa</label>
            <input type="date" name="tgl_periksa" value="{{ $filter['tgl_periksa'] }}"
                style="width:100%;box-sizing:border-box;height:36px;border-radius:8px;border:1px solid var(--line-2);background:var(--surface);color:var(--text);font-size:13px;padding:0 10px;outline:none;" />
        </div>
        <div>
            <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:5px;">Jenis Layanan</label>
            <select name="jenis_layanan"
                style="width:100%;box-sizing:border-box;height:36px;border-radius:8px;border:1px solid var(--line-2);background:var(--surface);color:var(--text);font-size:13px;padding:0 10px;outline:none;">
                @foreach($jenis_options as $opt)
                    <option value="{{ $opt }}" {{ $filter['jenis_layanan'] === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:5px;">Tempat Layanan</label>
            <select name="tempat_layanan"
                style="width:100%;box-sizing:border-box;height:36px;border-radius:8px;border:1px solid var(--line-2);background:var(--surface);color:var(--text);font-size:13px;padding:0 10px;outline:none;">
                @foreach($tempat_options as $opt)
                    <option value="{{ $opt }}" {{ $filter['tempat_layanan'] === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:5px;">Status Dilayani</label>
            <select name="status"
                style="width:100%;box-sizing:border-box;height:36px;border-radius:8px;border:1px solid var(--line-2);background:var(--surface);color:var(--text);font-size:13px;padding:0 10px;outline:none;">
                @foreach($status_options as $opt)
                    <option value="{{ $opt }}" {{ $filter['status'] === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:5px;">NO RM</label>
            <input type="text" name="no_rm" value="{{ $filter['no_rm'] }}" placeholder="Nomor Rekam Medis"
                style="width:100%;box-sizing:border-box;height:36px;border-radius:8px;border:1px solid var(--line-2);background:var(--surface);color:var(--text);font-size:13px;padding:0 10px;outline:none;" />
        </div>
        <div style="grid-column: span 3; display:flex; justify-content:flex-end; gap:8px;">
            <a href="{{ route($routeCurrent) }}" class="btn btn--ghost" style="height:36px;font-size:13px;border-radius:8px;display:inline-flex;align-items:center;gap:6px;">
                <svg class="ico" viewBox="0 0 24 24" style="width:13px;height:13px;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Reset
            </a>
            <button type="submit" class="btn btn--primary" style="height:36px;font-size:13px;border-radius:8px;display:inline-flex;align-items:center;gap:6px;padding:0 18px;">
                <svg class="ico" viewBox="0 0 24 24" style="width:13px;height:13px;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Cari Pasien
            </button>
        </div>
    </form>

    {{-- ── Meta bar ─────────────────────────────────────── --}}
    <div class="pt-meta"
        style="min-height:40px;color:var(--muted);justify-content:space-between;align-items:center;gap:10px;padding:4px 6px 8px;font-size:12.5px;display:flex;">
        <span>Daftar Pasien · Menampilkan <b>{{ count($patients) }}</b> kunjungan rawat jalan</span>
        <button type="button" class="btn btn--xs btn--ghost" onclick="toggleSelectAll(this)"
            style="display:inline-flex;align-items:center;gap:6px;">
            <svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;"><path d="m5 12.5 4.5 4.5L19 7.5"/></svg>
            <span>Pilih semua baris</span>
        </button>
    </div>

    {{-- ── Tabel Encounter ─────────────────────────────── --}}
    <div class="table-wrap pt-wrap" style="overflow-x:auto;">
        <table class="table pt-table">
            <thead>
                <tr>
                    <th scope="col" class="c-ck" style="width:44px;padding-right:0;">
                        <input type="checkbox" class="check" id="enc-check-all" onchange="selectAllRows(this)" aria-label="Pilih semua" />
                    </th>
                    <th scope="col" style="min-width:56px;font-weight:650;">NO</th>
                    <th scope="col" style="min-width:130px;">
                        <button type="button" style="color:inherit;display:inline-flex;align-items:center;gap:6px;font-weight:650;">
                            TGL
                            <span class="pt-sorti is-on" style="display:inline-grid;">
                                <svg class="ico" viewBox="0 0 24 24" style="width:13px;height:13px;"><path d="m6 9.5 6 6 6-6"/></svg>
                            </span>
                        </button>
                    </th>
                    <th scope="col" style="min-width:280px;">
                        <button type="button" style="color:inherit;display:inline-flex;align-items:center;gap:6px;font-weight:650;">
                            Pasien
                            <span class="pt-sorti" style="display:inline-grid;opacity:.5;">
                                <svg class="ico" viewBox="0 0 24 24" style="width:13px;height:13px;"><path d="m6 9.5 6 6 6-6"/></svg>
                            </span>
                        </button>
                    </th>
                    <th scope="col" style="min-width:240px;">
                        <button type="button" style="color:inherit;display:inline-flex;align-items:center;gap:6px;font-weight:650;">
                            Dokter
                            <span class="pt-sorti" style="display:inline-grid;opacity:.5;">
                                <svg class="ico" viewBox="0 0 24 24" style="width:13px;height:13px;"><path d="m6 9.5 6 6 6-6"/></svg>
                            </span>
                        </button>
                    </th>
                    <th scope="col" style="min-width:140px;text-align:right;padding-right:20px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $p)
                    <tr style="cursor:pointer;" onclick="toggleRowSelect(this, event)">
                        <td class="c-ck" style="width:44px;padding-right:0;">
                            <input type="checkbox" class="check enc-row-check" onclick="event.stopPropagation()" />
                        </td>
                        <td style="font-size:13px;color:var(--muted);font-weight:550;">{{ $p['no'] }}</td>
                        <td>
                            <div style="font-family:monospace;font-size:12.5px;font-weight:600;color:var(--text);white-space:nowrap;">
                                {{ now()->format('d-m-Y') }}
                            </div>
                            <small style="color:var(--muted);font-size:11.5px;font-family:monospace;">
                                {{ sprintf('%02d:%02d:%02d', 14 - $p['no'], rand(10,59), rand(0,59)) }}
                            </small>
                        </td>
                        <td>
                            <div class="cell-person" style="align-items:flex-start;gap:10px;display:flex;">
                                <span class="av av--md"
                                    style="width:34px;height:34px;border-radius:10px;background:rgba(184,51,106,.09);color:var(--primary);font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                                    {{ $p['initial'] }}
                                </span>
                                <div>
                                    <b style="font-weight:650;color:var(--text);font-size:13.5px;display:block;">
                                        {{ $p['rm_no'] }}
                                    </b>
                                    <span style="font-size:13px;font-weight:600;color:var(--text);display:block;">
                                        {{ $p['name'] }}
                                        <span style="font-size:11.5px;font-weight:500;color:var(--muted);">{{ $p['gender'] }}</span>
                                    </span>
                                    @if($p['nik'])
                                        <small style="color:var(--muted);font-size:11.5px;font-family:monospace;">{{ $p['nik'] }}</small>
                                    @endif
                                    @if($p['no_rm'])
                                        <br><small style="color:var(--primary);font-size:11.5px;font-family:monospace;">{{ $p['no_rm'] }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:650;color:var(--text);">{{ $p['doctor'] }}</div>
                            <small style="color:var(--muted);font-size:11.5px;font-family:monospace;display:block;">{{ $p['doctor_id'] }}</small>
                            <small style="color:var(--muted);font-size:11.5px;font-family:monospace;">{{ $p['ihs'] }}</small>
                        </td>
                        <td style="text-align:right;padding-right:16px;">
                            @if($p['action_status'] === 'success')
                                <span class="consent consent--opted-in"
                                    style="white-space:nowrap;align-items:center;gap:5px;font-size:12px;font-weight:650;display:inline-flex;color:#1e7e34;">
                                    <svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;stroke:#1e7e34;"><polyline points="20 6 9 17 4 12"/></svg>
                                    Encounter<br>Success
                                </span>
                            @else
                                <button type="button"
                                    onclick="event.stopPropagation(); sendEncounter(this, '{{ $p['rm_no'] }}')"
                                    style="
                                        background: #38c172; color: #fff; border: none; cursor: pointer;
                                        font-size: 13px; font-weight: 700; padding: 6px 16px;
                                        border-radius: 8px; display: inline-flex; align-items: center; gap: 5px;
                                        white-space: nowrap;
                                    ">
                                    Encounter
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@push('scripts')
<script>
    function selectAllRows(master) {
        document.querySelectorAll('.enc-row-check').forEach(ck => {
            ck.checked = master.checked;
            const tr = ck.closest('tr');
            if (tr) { master.checked ? tr.classList.add('is-sel') : tr.classList.remove('is-sel'); }
        });
    }
    function toggleSelectAll(btn) {
        const master = document.getElementById('enc-check-all');
        if (master) { master.checked = !master.checked; selectAllRows(master); }
    }
    function toggleRowSelect(tr, e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON' || e.target.closest('button')) return;
        const ck = tr.querySelector('.enc-row-check');
        if (ck) { ck.checked = !ck.checked; ck.checked ? tr.classList.add('is-sel') : tr.classList.remove('is-sel'); }
    }
    function sendEncounter(btn, rm) {
        const orig = btn.innerHTML;
        btn.disabled = true; btn.style.opacity = '.6'; btn.innerHTML = '...';
        setTimeout(() => {
            btn.closest('td').innerHTML = '<span style="white-space:nowrap;align-items:center;gap:5px;font-size:12px;font-weight:650;display:inline-flex;color:#1e7e34;"><svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:#1e7e34;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;"><polyline points="20 6 9 17 4 12"/></svg>Encounter<br>Success</span>';
        }, 1100);
    }
    function syncEncounterNow(btn) {
        const orig = btn.innerHTML; btn.disabled = true;
        btn.innerHTML = '<svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;animation:spin 1s linear infinite;"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg><span>Menghubungkan...</span>';
        setTimeout(() => {
            btn.innerHTML = '<svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;"><polyline points="20 6 9 17 4 12"/></svg><span>Sinkron Selesai!</span>';
            setTimeout(() => { btn.innerHTML = orig; btn.disabled = false; }, 2500);
        }, 1500);
    }
</script>
<style>
    @keyframes spin { 100% { transform: rotate(360deg); } }
    .table tbody tr.is-sel { background: color-mix(in srgb, var(--primary) 7%, transparent) !important; }
    .table tbody tr.is-sel:hover { background: color-mix(in srgb, var(--primary) 10%, transparent) !important; }
    @media (max-width: 900px) {
        .enc-metrics-strip { flex-direction: column !important; }
        .enc-metrics-strip > div { border-right: none !important; border-bottom: 1px solid var(--line); }
        .enc-filter-form { grid-template-columns: 1fr 1fr !important; }
    }
    @media (max-width: 560px) {
        .enc-filter-form { grid-template-columns: 1fr !important; }
    }
</style>
@endpush
@endsection

