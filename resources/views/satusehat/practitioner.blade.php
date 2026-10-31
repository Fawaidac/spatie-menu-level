@extends('layouts.app')

@section('content')
<section
    class="card td-satusehat"
    id="td-satusehat-practitioner"
    aria-labelledby="td-practitioner-title"
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
            <button
                type="button"
                class="btn btn--primary"
                onclick="syncPractitionerNow(this)"
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
                <span>Sinkronisasi Sekarang</span>
            </button>
        </div>
    </div>

    {{-- Ringkasan Metrics Card --}}
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
        <div style="flex: 1; padding: 14px 18px; border-right: 1px solid var(--line)">
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
                Total Tenaga Medis
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
                <small style="font-size: 11px; font-weight: 600; color: #1e7e34">Orang</small>
            </div>
        </div>

        <div style="flex: 1; padding: 14px 18px; border-right: 1px solid var(--line)">
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
                Terverifikasi Kemenkes
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
                <small style="font-size: 11px; font-weight: 600; color: #1e7e34">IHS Aktif</small>
            </div>
        </div>

        <div style="flex: 1; padding: 14px 18px; border-right: 1px solid var(--line)">
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
                <small style="font-size: 11px; font-weight: 500; color: var(--muted)">Spesialis</small>
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
                    <th scope="col" style="text-align: right; width: 90px; padding-left: 0">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($practitioners as $p)
                    <tr style="cursor: pointer" onclick="toggleRowSelect(this, event)">
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
                                IHS: {{ $p['ihs_number'] }}
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
                            <span class="badge" style="background: rgba(52, 199, 89, 0.12); color: #1e7e34; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 999px;">
                                {{ $p['status_label'] }}
                            </span>
                        </td>
                        <td style="text-align: right; padding-right: 14px;">
                            <button
                                type="button"
                                class="btn btn--xs btn--ghost"
                                onclick="copyIhs('{{ $p['ihs_number'] }}', event)"
                                title="Salin IHS Number"
                                style="padding: 4px 8px; font-size: 11px;"
                            >
                                Salin IHS
                            </button>
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
        e.stopPropagation();
        navigator.clipboard.writeText(ihs).then(() => {
            alert('IHS Number ' + ihs + ' disalin!');
        });
    }
    function syncPractitionerNow(btn) {
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

