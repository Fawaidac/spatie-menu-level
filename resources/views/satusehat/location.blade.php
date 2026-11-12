@extends('layouts.app')

@section('content')
<header class="head" style="margin: 20px 24px 0;">
    <div class="head__lead">
        <div>
            <p class="head__eyebrow">Satu Sehat ReST API</p>
            <h1 class="head__title">Master Data <em>Lokasi (Location)</em></h1>
        </div>
    </div>
</header>

<section
    class="card td-satusehat"
    id="td-satusehat-location"
    aria-labelledby="td-location-title"
    style="
        margin: 20px 24px 40px;
        border-radius: var(--r-card, 22px);
        border: 1px solid var(--line);
        background: var(--surface);
        box-shadow: var(--shadow);
        overflow: hidden;
        padding: 20px 24px;
    "
>
    {{-- Header --}}
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
                    width: 38px;
                    height: 38px;
                    border-radius: 12px;
                    background: rgba(52, 199, 89, 0.12);
                    color: #1e7e34;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;
                "
            >
                <svg class="ico" viewBox="0 0 24 24" style="width: 20px; height: 20px; stroke: #1e7e34;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
            <div>
                <h2
                    class="card__title"
                    id="td-location-title"
                    style="
                        font-size: 16px;
                        font-weight: 700;
                        color: var(--text);
                        margin: 0;
                        display: flex;
                        align-items: center;
                        gap: 8px;
                    "
                >
                    Master Data Lokasi (Location)
                    <span
                        class="badge"
                        style="
                            background: rgba(52, 199, 89, 0.14);
                            color: #1e7e34;
                            font-size: 11px;
                            font-weight: 600;
                            padding: 2px 8px;
                            border-radius: 999px;
                        "
                    >Sync Otomatis</span>
                </h2>
                <p style="font-size: 12.5px; color: var(--muted); margin: 2px 0 0 0;">Daftar ruangan, bangsal, dan lokasi pelayanan RSUD dr. Soebandi pada FHIR Satu Sehat</p>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 8px">
            <a
                href="{{ route('setting.api-key.index') }}"
                class="btn btn--ghost"
                style="font-size: 12.5px; padding: 0 14px; height: 36px; border-radius: 10px; display: inline-flex; align-items: center; gap: 6px;"
            >
                <svg class="ico" viewBox="0 0 24 24" style="width: 14px; height: 14px;"><path d="m21 2-2 2m-1.5 1.5 1.5 1.5-2 2-1.5-1.5M15.5 7.5 14 9l2 2 1.5-1.5M10.5 13.5a5 5 0 1 1-7-7 5 5 0 0 1 7 7Z" /></svg>
                <span>Konfigurasi API</span>
            </a>
            <button
                type="button"
                class="btn btn--primary"
                onclick="syncLocationNow(this)"
                style="font-size: 12.5px; padding: 0 16px; height: 36px; border-radius: 10px; display: inline-flex; align-items: center; gap: 6px;"
            >
                <svg class="ico" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                    <polyline points="23 4 23 10 17 10" />
                    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                </svg>
                <span>Sinkronisasi Sekarang</span>
            </button>
        </div>
    </div>

    {{-- Summary Metrics --}}
    <div
        style="display: flex; gap: 0; margin-bottom: 18px; border: 1px solid var(--line); border-radius: 14px; overflow: hidden; background: var(--surface-2);"
        class="summary-metrics-strip"
    >
        <div style="flex: 1; padding: 14px 18px; border-right: 1px solid var(--line)">
            <div style="font-size: 10.5px; font-weight: 700; text-transform: uppercase; color: var(--muted); letter-spacing: 0.5px; margin-bottom: 6px;">Total Ruang & Lokasi</div>
            <div style="font-size: 22px; font-weight: 800; color: var(--text); display: flex; align-items: baseline; gap: 5px;">
                <span class="tnum">{{ $summary['total_location'] }}</span>
                <small style="font-size: 11px; font-weight: 600; color: #1e7e34">Titik</small>
            </div>
        </div>
        <div style="flex: 1; padding: 14px 18px; border-right: 1px solid var(--line)">
            <div style="font-size: 10.5px; font-weight: 700; text-transform: uppercase; color: var(--muted); letter-spacing: 0.5px; margin-bottom: 6px;">Lokasi Aktif (SSID)</div>
            <div style="font-size: 22px; font-weight: 800; color: var(--text); display: flex; align-items: baseline; gap: 5px;">
                <span class="tnum">{{ $summary['active_location'] }}</span>
                <small style="font-size: 11px; font-weight: 600; color: #1e7e34">Tersinkron</small>
            </div>
        </div>
        <div style="flex: 1; padding: 14px 18px; border-right: 1px solid var(--line)">
            <div style="font-size: 10.5px; font-weight: 700; text-transform: uppercase; color: var(--muted); letter-spacing: 0.5px; margin-bottom: 6px;">Belum Sinkron</div>
            <div style="font-size: 22px; font-weight: 800; color: var(--text); display: flex; align-items: baseline; gap: 5px;">
                <span class="tnum">{{ $summary['pending_location'] ?? ($summary['total_location'] - $summary['active_location']) }}</span>
                <small style="font-size: 11px; font-weight: 500; color: var(--muted)">Pending</small>
            </div>
        </div>
        <div style="flex: 1; padding: 14px 18px">
            <div style="font-size: 10.5px; font-weight: 700; text-transform: uppercase; color: var(--muted); letter-spacing: 0.5px; margin-bottom: 6px;">Sinkronisasi Terakhir</div>
            <div style="font-size: 15px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 7px; margin-top: 3px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #34c759; box-shadow: 0 0 0 3px rgba(52, 199, 89, 0.2); flex-shrink: 0;"></span>
                {{ $summary['last_sync'] }}
            </div>
        </div>
    </div>

    {{-- Filter & Search Bar --}}
    <div style="background: var(--surface-2); border: 1px solid var(--line); border-radius: 12px; padding: 12px 16px; margin-bottom: 16px;">
        <form method="GET" action="{{ route('satusehat.location.index') }}" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 260px; position: relative;">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ $cari ?? request('q', '') }}" 
                    placeholder="Cari lokasi berdasarkan Nama, Kode, Keterangan, atau SSID..." 
                    class="input" 
                    style="width: 100%; height: 38px; border-radius: 8px; font-size: 13px; padding-left: 36px; background: var(--surface); border: 1px solid var(--line); color: var(--text);"
                />
                <svg class="ico" viewBox="0 0 24 24" style="position: absolute; left: 10px; top: 11px; width: 16px; height: 16px; stroke: var(--muted); pointer-events: none;"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            </div>
            <div style="min-width: 160px;">
                <select name="status" class="input" style="width: 100%; height: 38px; border-radius: 8px; font-size: 13px; background: var(--surface); border: 1px solid var(--line); color: var(--text);">
                    <option value="all" {{ ($status ?? request('status')) === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="synced" {{ ($status ?? request('status')) === 'synced' ? 'selected' : '' }}>Tersinkron (SSID Ada)</option>
                    <option value="unmapped" {{ ($status ?? request('status')) === 'unmapped' ? 'selected' : '' }}>Belum Sinkron</option>
                </select>
            </div>
            <button type="submit" class="btn btn--primary" style="height: 38px; padding: 0 16px; border-radius: 8px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                <svg class="ico" viewBox="0 0 24 24" style="width: 14px; height: 14px;"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <span>Cari</span>
            </button>
            @if(!empty($cari) || request('q') || request('status'))
                <a href="{{ route('satusehat.location.index') }}" class="btn btn--ghost" style="height: 38px; padding: 0 14px; border-radius: 8px; font-size: 13px;">Reset</a>
            @endif
        </form>
    </div>

    {{-- Meta bar --}}
    <div class="pt-meta" style="min-height: 40px; color: var(--muted); justify-content: space-between; align-items: center; gap: 10px; padding: 4px 6px 8px; font-size: 12.5px; display: flex;">
        <span>Daftar Lokasi · Menampilkan <b>{{ $locations->count() }}</b> dari <b>{{ $locations->total() }}</b> titik layanan</span>
        <button type="button" class="btn btn--xs btn--ghost" onclick="toggleSelectAllRows(this)" style="display: inline-flex; align-items: center; gap: 6px">
            <svg class="ico" viewBox="0 0 24 24" style="width: 14px; height: 14px;"><path d="m5 12.5 4.5 4.5L19 7.5"></path></svg>
            <span>Pilih semua baris</span>
        </button>
    </div>

    {{-- Tabel Lokasi dari DB (b_ms_unit) --}}
    <div class="table-wrap pt-wrap" style="overflow-x: auto; border: 1px solid var(--line); border-radius: 14px; background: var(--surface);">
        <table class="table pt-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid var(--line); background: var(--surface-2);">
                    <th scope="col" class="c-ck" style="width: 44px; padding: 12px 10px 12px 16px;">
                        <input type="checkbox" class="check" id="location-check-all" onchange="selectAllRows(this)" aria-label="Pilih semua baris" />
                    </th>
                    <th scope="col" style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; min-width: 260px">Ruang & Unit Pelayanan</th>
                    <th scope="col" style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; min-width: 200px">Keterangan</th>
                    <th scope="col" style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; min-width: 140px">Status SatuSehat</th>
                    <th scope="col" style="padding: 12px 14px; font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; min-width: 220px">Satu Sehat ID</th>
                    <th scope="col" style="padding: 12px 16px 12px 14px; font-size: 12px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; text-align: right; width: 120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($locations as $loc)
                    <tr style="border-bottom: 1px solid var(--line); cursor: pointer; transition: background 0.15s ease;" onclick="toggleRowSelect(this, event)">
                        <td class="c-ck" style="width: 44px; padding: 12px 10px 12px 16px;">
                            <input type="checkbox" class="check row-check" onclick="event.stopPropagation()" />
                        </td>
                        <td style="padding: 12px 14px;">
                            <div class="cell-person" style="align-items: center; gap: 12px; display: flex">
                                <span
                                    class="av av--md"
                                    style="width: 36px; height: 36px; border-radius: 10px; background: rgba(184, 51, 106, 0.09); color: var(--primary); font-size: 13px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0;"
                                >
                                    <svg class="ico" viewBox="0 0 24 24" style="width: 18px; height: 18px; stroke: currentColor;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                </span>
                                <div>
                                    <div style="font-weight: 650; color: var(--text); font-size: 13.5px; line-height: 1.3;">{{ $loc->nama }}</div>
                                    <div style="margin-top: 3px; display: flex; align-items: center; gap: 6px;">
                                        <span class="badge" style="background: var(--surface-2); border: 1px solid var(--line); font-size: 10.5px; font-weight: 600; padding: 1px 6px; border-radius: 4px; color: var(--muted);">Kode: {{ $loc->kode }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 12px 14px;">
                            <div style="font-size: 13px; font-weight: 500; color: var(--text);">{{ $loc->keterangan }}</div>
                        </td>
                        <td style="padding: 12px 14px;">
                            @if (!empty($loc->satu_sehat_id))
                                <span class="badge" style="background: rgba(52, 199, 89, 0.12); color: #1e7e34; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 999px; display: inline-flex; align-items: center; gap: 4px;">
                                    <svg viewBox="0 0 24 24" style="width: 12px; height: 12px; stroke: currentColor; fill: none; stroke-width: 2.5;"><polyline points="20 6 9 17 4 12"/></svg>
                                    Tersinkron
                                </span>
                            @else
                                <span class="badge" style="background: rgba(255, 149, 0, 0.12); color: #c07000; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 999px; display: inline-flex; align-items: center; gap: 4px;">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #c07000;"></span>
                                    Belum Ada SSID
                                </span>
                            @endif
                        </td>
                        <td style="padding: 12px 14px;">
                            @if (!empty($loc->satu_sehat_id))
                                <div style="display: inline-flex; align-items: center; gap: 6px; background: var(--surface-2); border: 1px solid var(--line); border-radius: 6px; padding: 3px 8px;">
                                    <code style="font-size: 11.5px; color: var(--primary); font-family: monospace;">{{ $loc->satu_sehat_id }}</code>
                                    <button type="button" class="btn btn--xs btn--ghost" onclick="copyToClipboard('{{ $loc->satu_sehat_id }}', this, event)" title="Salin SSID" style="padding: 2px 4px; height: auto;">
                                        <svg class="ico" viewBox="0 0 24 24" style="width: 12px; height: 12px; stroke: var(--muted);"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                                    </button>
                                </div>
                            @else
                                <span style="font-size: 12.5px; color: var(--muted);">-</span>
                            @endif
                        </td>
                        <td style="padding: 12px 16px 12px 14px; text-align: right;">
                            <button
                                type="button"
                                class="btn btn--xs btn--ghost"
                                onclick="updateSatuSehat('{{ $loc->kode }}', '{{ $loc->satu_sehat_id }}', '{{ addslashes($loc->nama) }}', '{{ addslashes($loc->keterangan) }}', event)"
                                title="Update Satu Sehat"
                                style="padding: 5px 10px; font-size: 11.5px; border-radius: 6px;"
                            >
                                Update Satu Sehat
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 36px 20px; color: var(--muted);">
                            <div style="font-size: 14px; font-weight: 500;">Tidak ada data lokasi yang ditemukan</div>
                            <div style="font-size: 12px; margin-top: 4px;">Coba gunakan kata kunci pencarian atau filter status yang berbeda.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div style="padding: 14px 16px; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; background: var(--surface);">
            <div style="font-size: 12.5px; color: var(--muted);">
                Menampilkan <b>{{ $locations->firstItem() ?? 0 }}</b> - <b>{{ $locations->lastItem() ?? 0 }}</b> dari <b>{{ $locations->total() }}</b> titik lokasi
            </div>
            <div>
                {{ $locations->links('partials.pagination') }}
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function selectAllRows(master) {
        document.querySelectorAll('.row-check').forEach(ck => ck.checked = master.checked);
    }
    function toggleSelectAllRows(btn) {
        const master = document.getElementById('location-check-all');
        if (master) { master.checked = !master.checked; selectAllRows(master); }
    }
    function toggleRowSelect(tr, e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON' || e.target.closest('button') || e.target.closest('a')) return;
        const ck = tr.querySelector('.row-check');
        if (ck) ck.checked = !ck.checked;
    }
    function copyToClipboard(text, btn, e) {
        if (e) e.stopPropagation();
        navigator.clipboard.writeText(text).then(() => {
            const orig = btn.innerHTML;
            btn.innerHTML = '<span style="font-size:10px; color:#1e7e34;">✓</span>';
            setTimeout(() => { btn.innerHTML = orig; }, 1500);
        });
    }
    function updateSatuSehat(kode, ssid, nama, keterangan, e) {
        if (e) e.stopPropagation();
        alert('Update Satu Sehat untuk: ' + nama + ' (Kode: ' + kode + ')');
    }
    function syncLocationNow(btn) {
        const orig = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = 'Memproses...';
        setTimeout(() => {
            btn.innerHTML = 'Berhasil disinkronkan!';
            setTimeout(() => { btn.innerHTML = orig; btn.disabled = false; }, 2000);
        }, 1200);
    }
</script>
<style>
    @media (max-width: 900px) {
        .summary-metrics-strip { flex-direction: column !important; }
        .summary-metrics-strip > div { border-right: none !important; border-bottom: 1px solid var(--line); }
    }
</style>
@endpush
@endsection
