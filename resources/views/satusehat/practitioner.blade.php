@extends('layouts.app')

@section('title', 'Practitioner (Tenaga Medis) - Satu Sehat RSD dr. Soebandi')

@section('content')
<section class="card td-practitioners" aria-labelledby="td-practitioner-title">
    {{-- Card Header --}}
    <div
        class="card__header"
        style="
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 18px 20px;
            border-bottom: 1px solid var(--line);
            flex-wrap: wrap;
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
                <svg class="ico" viewBox="0 0 24 24" style="width: 20px; height: 20px; stroke: #1e7e34;"><circle cx="9" cy="8.5" r="3.5"/><path d="M3 19.5c.6-3.2 3-5 6-5s5.4 1.8 6 5"/><path d="M15.5 5.2a3.5 3.5 0 0 1 0 6.6M17.5 14.8c1.8.6 3 2.2 3.5 4.7"/></svg>
            </div>
            <div>
                <h2
                    class="card__title"
                    id="td-practitioner-title"
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
                    Tenaga Medis & Praktisi (Practitioner)
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
                <p style="
                    font-size: 12.5px;
                    color: var(--muted);
                    margin: 2px 0 0 0;
                ">Data dokter spesialis, perawat, dan nakes RSUD dr. Soebandi terintegrasi platform SATUSEHAT</p>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 8px">
            <a
                href="{{ route('setting.api-key.index') }}"
                class="btn btn--ghost"
                style="
                    font-size: 12.5px;
                    padding: 0 14px;
                    height: 36px;
                    border-radius: 10px;
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                "
            >
                <svg class="ico" viewBox="0 0 24 24" style="width: 14px; height: 14px;"><path d="m21 2-2 2m-1.5 1.5 1.5 1.5-2 2-1.5-1.5M15.5 7.5 14 9l2 2 1.5-1.5M10.5 13.5a5 5 0 1 1-7-7 5 5 0 0 1 7 7Z" /></svg>
                <span>Konfigurasi API</span>
            </a>
            <a
                href="{{ route('satusehat.practitioner.index') }}"
                class="btn btn--primary"
                style="
                    font-size: 12.5px;
                    padding: 0 16px;
                    height: 36px;
                    border-radius: 10px;
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                "
            >
                <svg class="ico" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                    <polyline points="23 4 23 10 17 10" />
                    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                </svg>
                <span>Refresh Data</span>
            </a>
        </div>
    </div>

    {{-- Summary Metrics --}}
    <div
        style="
            display: flex;
            gap: 0;
            margin-bottom: 18px;
            border: 1px solid var(--line);
            border-radius: 14px;
            overflow: hidden;
            background: var(--surface-2);
        "
        class="summary-metrics-strip"
    >
        <div
            style="
                flex: 1;
                padding: 14px 18px;
                border-right: 1px solid var(--line);
            "
        >
            <div
                style="
                    font-size: 10.5px;
                    font-weight: 700;
                    text-transform: uppercase;
                    color: var(--muted);
                    letter-spacing: 0.5px;
                    margin-bottom: 6px;
                "
            >
                Total Nakes Terdaftar
            </div>
            <div
                style="
                    font-size: 22px;
                    font-weight: 800;
                    color: var(--text);
                    display: flex;
                    align-items: baseline;
                    gap: 5px;
                "
            >
                <span class="tnum">{{ $summary['total_practitioners'] }}</span>
                <small style="font-size: 11px; font-weight: 600; color: #1e7e34"
                    >Pegawai</small
                >
            </div>
        </div>
        <div
            style="
                flex: 1;
                padding: 14px 18px;
                border-right: 1px solid var(--line);
            "
        >
            <div
                style="
                    font-size: 10.5px;
                    font-weight: 700;
                    text-transform: uppercase;
                    color: var(--muted);
                    letter-spacing: 0.5px;
                    margin-bottom: 6px;
                "
            >
                Nakes Terverifikasi IHS
            </div>
            <div
                style="
                    font-size: 22px;
                    font-weight: 800;
                    color: var(--text);
                    display: flex;
                    align-items: baseline;
                    gap: 5px;
                "
            >
                <span class="tnum">{{ $summary['active_practitioners'] }}</span>
                <small style="font-size: 11px; font-weight: 600; color: #1e7e34"
                    >IHS Valid</small
                >
            </div>
        </div>
        <div
            style="
                flex: 1;
                padding: 14px 18px;
                border-right: 1px solid var(--line);
            "
        >
            <div
                style="
                    font-size: 10.5px;
                    font-weight: 700;
                    text-transform: uppercase;
                    color: var(--muted);
                    letter-spacing: 0.5px;
                    margin-bottom: 6px;
                "
            >
                Dokter Spesialis
            </div>
            <div
                style="
                    font-size: 22px;
                    font-weight: 800;
                    color: var(--text);
                    display: flex;
                    align-items: baseline;
                    gap: 5px;
                "
            >
                <span class="tnum">{{ $summary['specialist_count'] }}</span>
                <small style="font-size: 11px; font-weight: 500; color: var(--muted)"
                    >Spesialis</small
                >
            </div>
        </div>
        <div style="flex: 1; padding: 14px 18px">
            <div
                style="
                    font-size: 10.5px;
                    font-weight: 700;
                    text-transform: uppercase;
                    color: var(--muted);
                    letter-spacing: 0.5px;
                    margin-bottom: 6px;
                "
            >
                Sinkronisasi Terakhir
            </div>
            <div
                style="
                    font-size: 15px;
                    font-weight: 700;
                    color: var(--text);
                    display: flex;
                    align-items: center;
                    gap: 7px;
                    margin-top: 3px;
                "
            >
                <span
                    style="
                        width: 8px;
                        height: 8px;
                        border-radius: 50%;
                        background: #34c759;
                        box-shadow: 0 0 0 3px rgba(52, 199, 89, 0.2);
                        flex-shrink: 0;
                    "
                ></span>
                {{ $summary['last_sync'] }}
            </div>
        </div>
    </div>

    {{-- Filter & Search Bar --}}
    <div style="background: var(--surface-2); border: 1px solid var(--line); border-radius: 12px; padding: 12px 16px; margin-bottom: 16px;">
        <form method="GET" action="{{ route('satusehat.practitioner.index') }}" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 260px; position: relative;">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ $cari ?? request('q', '') }}" 
                    placeholder="Cari nakes berdasarkan Nama, NIK, atau IHS..." 
                    class="input" 
                    style="width: 100%; height: 38px; border-radius: 8px; font-size: 13px; padding-left: 36px; background: var(--surface); border: 1px solid var(--line); color: var(--text);"
                />
                <svg class="ico" viewBox="0 0 24 24" style="position: absolute; left: 10px; top: 11px; width: 16px; height: 16px; stroke: var(--muted); pointer-events: none;"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            </div>
            <div style="min-width: 150px;">
                <select name="status" class="input" style="width: 100%; height: 38px; border-radius: 8px; font-size: 13px; background: var(--surface); border: 1px solid var(--line); color: var(--text);">
                    <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Terverifikasi (IHS Ada)</option>
                    <option value="unmapped" {{ request('status') === 'unmapped' ? 'selected' : '' }}>Belum Sinkron</option>
                </select>
            </div>
            <button type="submit" class="btn btn--primary" style="height: 38px; padding: 0 16px; border-radius: 8px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                <svg class="ico" viewBox="0 0 24 24" style="width: 14px; height: 14px;"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <span>Cari</span>
            </button>
            @if(!empty($cari) || request('q') || request('status'))
                <a href="{{ route('satusehat.practitioner.index') }}" class="btn btn--ghost" style="height: 38px; padding: 0 14px; border-radius: 8px; font-size: 13px;">Reset</a>
            @endif
        </form>
    </div>

    {{-- Meta bar --}}
    <div
        class="pt-meta"
        style="
            min-height: 40px;
            color: var(--muted);
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 4px 6px 8px;
            font-size: 12.5px;
            display: flex;
        "
    >
        <span>Daftar Nakes · Menampilkan <b>{{ count($practitioners) }}</b> dari <b>{{ $summary['total_practitioners'] }}</b> nakes terdaftar</span>
        <button
            type="button"
            class="btn btn--xs btn--ghost"
            onclick="toggleSelectAllRows(this)"
            style="display: inline-flex; align-items: center; gap: 6px"
        >
            <svg class="ico" viewBox="0 0 24 24" style="width: 14px; height: 14px;"><path d="m5 12.5 4.5 4.5L19 7.5"></path></svg>
            <span>Pilih semua baris</span>
        </button>
    </div>

    {{-- Tabel Practitioner --}}
    <div class="table-wrap pt-wrap" style="overflow-x: auto">
        <table class="table pt-table">
            <thead>
                <tr>
                    <th scope="col" class="c-ck" style="width: 44px; padding-right: 0">
                        <input
                            type="checkbox"
                            class="check"
                            id="practitioner-check-all"
                            onchange="selectAllRows(this)"
                            aria-label="Pilih semua baris"
                        />
                    </th>
                    <th scope="col" style="min-width: 250px">Nama & Tenaga Medis</th>
                    <th scope="col" style="min-width: 160px">IHS / NIK Kemenkes</th>
                    <th scope="col" style="min-width: 180px">Profesi & Spesialisasi</th>
                    <th scope="col" style="min-width: 170px">Nomor SIP / STR</th>
                    <th scope="col" style="min-width: 170px">Unit Pelayanan</th>
                    <th scope="col" style="min-width: 120px">Status</th>
                    <th scope="col" style="text-align: right; width: 140px; padding-right: 14px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($practitioners as $p)
                    <tr id="row-nakes-{{ $p['nik'] }}" style="cursor: pointer" onclick="toggleRowSelect(this, event)">
                        <td class="c-ck" style="width: 44px; padding-right: 0">
                            <input
                                type="checkbox"
                                class="check row-check"
                                onclick="event.stopPropagation()"
                            />
                        </td>
                        <td>
                            <div class="cell-person" style="align-items: center; gap: 10px; display: flex">
                                <span
                                    class="av av--md"
                                    style="
                                        width: 34px;
                                        height: 34px;
                                        border-radius: 10px;
                                        background: rgba(184, 51, 106, 0.09);
                                        color: var(--primary);
                                        font-size: 12px;
                                        font-weight: 700;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        flex-shrink: 0;
                                    "
                                >
                                    {{ $p['initials'] }}
                                </span>
                                <div>
                                    <b style="font-weight: 650; color: var(--text); font-size: 13.5px;">
                                        {{ $p['name'] }}
                                    </b>
                                    <small style="color: var(--muted); font-size: 12px; display: block; margin-top: 1px;">
                                        {{ $p['phone'] }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-family: monospace; font-size: 12.5px; font-weight: 700; color: var(--primary);">
                                IHS: <span class="ihs-val">{{ $p['ihs_number'] }}</span>
                            </div>
                            <div style="font-family: monospace; font-size: 11px; color: var(--muted);">
                                NIK: {{ $p['nik'] }}
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 13px; font-weight: 600; color: var(--text);">{{ $p['specialty'] }}</div>
                            <small style="color: var(--muted); font-size: 11.5px;">{{ $p['role'] }}</small>
                        </td>
                        <td>
                            <div style="font-size: 12px; font-family: monospace; color: var(--text);">SIP: {{ $p['sip'] }}</div>
                            <div style="font-size: 11px; font-family: monospace; color: var(--muted);">STR: {{ $p['str'] }}</div>
                        </td>
                        <td>
                            <span class="badge" style="background: var(--surface-2); border: 1px solid var(--line); color: var(--text); font-size: 11.5px; padding: 2px 8px; border-radius: 6px;">
                                {{ $p['unit'] }}
                            </span>
                        </td>
                        <td>
                            @if($p['status'] === 'active')
                                <span class="badge" style="background: rgba(52, 199, 89, 0.12); color: #1e7e34; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 999px;">
                                    {{ $p['status_label'] }}
                                </span>
                            @else
                                <span class="badge" style="background: rgba(255, 149, 0, 0.12); color: #b25e00; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 999px;">
                                    {{ $p['status_label'] }}
                                </span>
                            @endif
                        </td>
                        <td style="text-align: right; padding-right: 14px; white-space: nowrap;">
                            @if($p['ihs_number'] === '-' || empty($p['ihs_number']))
                                <button
                                    type="button"
                                    class="btn btn--xs btn--primary"
                                    onclick="syncPractitioner('{{ $p['nik'] }}', 'tambah', '', this, event)"
                                    title="Tarik IHS dari SATUSEHAT berdasarkan NIK"
                                    style="padding: 4px 10px; font-size: 11px; margin-right: 4px;"
                                >
                                    Sync NIK
                                </button>
                            @else
                                <button
                                    type="button"
                                    class="btn btn--xs btn--ghost"
                                    onclick="syncPractitioner('{{ $p['nik'] }}', 'update', '{{ $p['ihs_number'] }}', this, event)"
                                    title="Perbarui data dari SATUSEHAT"
                                    style="padding: 4px 8px; font-size: 11px; margin-right: 4px;"
                                >
                                    Update
                                </button>
                                <button
                                    type="button"
                                    class="btn btn--xs btn--ghost"
                                    onclick="copyIhs('{{ $p['ihs_number'] }}', event)"
                                    title="Salin IHS Number"
                                    style="padding: 4px 8px; font-size: 11px;"
                                >
                                    Salin
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 36px 20px; color: var(--muted);">
                            Tidak ada data tenaga medis yang cocok dengan pencarian Anda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(method_exists($practitioners, 'links'))
        <div style="padding: 16px 12px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--line); flex-wrap: wrap; gap: 10px;">
            <div style="font-size: 12px; color: var(--muted);">
                Menampilkan halaman {{ $practitioners->currentPage() }} dari {{ $practitioners->lastPage() }}
            </div>
            <div>
                {{ $practitioners->links('partials.pagination') }}
            </div>
        </div>
    @endif
</section>

@push('scripts')
<script>
    function selectAllRows(master) {
        document.querySelectorAll('.row-check').forEach(ck => ck.checked = master.checked);
    }
    function toggleSelectAllRows(btn) {
        const master = document.getElementById('practitioner-check-all');
        if (master) {
            master.checked = !master.checked;
            selectAllRows(master);
        }
    }
    function toggleRowSelect(tr, e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON' || e.target.closest('button')) return;
        const ck = tr.querySelector('.row-check');
        if (ck) ck.checked = !ck.checked;
    }
    function copyIhs(ihs, e) {
        if (e) e.stopPropagation();
        navigator.clipboard.writeText(ihs).then(() => {
            alert('IHS Number ' + ihs + ' disalin!');
        });
    }

    function syncPractitioner(nik, status, ssid, btn, e) {
        if (e) e.stopPropagation();
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = 'Syncing...';

        fetch('{{ route("satusehat.practitioner.sync") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                nik: nik,
                status: status,
                ssid: ssid
            })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = originalText;
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                alert(data.message || 'Gagal sinkronisasi data');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = originalText;
            alert('Terjadi kesalahan koneksi atau server');
        });
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
