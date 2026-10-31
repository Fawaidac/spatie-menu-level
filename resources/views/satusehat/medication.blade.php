@extends('layouts.app')

@section('content')
<section
    class="card td-satusehat"
    id="td-satusehat-medication"
    aria-labelledby="td-medication-title"
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
                <svg class="ico" viewBox="0 0 24 24" style="width: 20px; height: 20px; stroke: #1e7e34;"><path d="M10.5 20.5 3.5 13.5a5 5 0 0 1 7-7l7 7a5 5 0 0 1-7 7Z"/><path d="m8.5 8.5 7 7"/></svg>
            </div>
            <div>
                <h2
                    class="card__title"
                    id="td-medication-title"
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
                    Katalog Obat & Farmasi (Medication)
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
                ">Pemetaan formularium obat SIMRS RSUD dr. Soebandi ke Kamus Farmasi & Alat Kesehatan (KFA)</p>
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
                onclick="syncMedicationNow(this)"
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
                Total Item Obat
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
                <span class="tnum">{{ $summary['total_medications'] }}</span>
                <small style="font-size: 11px; font-weight: 600; color: #1e7e34">Item</small>
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
                Terpetakan KFA
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
                <span class="tnum">{{ $summary['mapped_kfa'] }}</span>
                <small style="font-size: 11px; font-weight: 600; color: #1e7e34">Valid Kemkes</small>
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
                Obat Keras & Resep
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
                <span class="tnum">{{ $summary['hard_drugs'] }}</span>
                <small style="font-size: 11px; font-weight: 500; color: var(--muted)">Formularium</small>
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
        <span>Daftar Obat · Menampilkan <b>{{ count($medications) }}</b> dari <b>{{ $summary['total_medications'] }}</b> formularium obat</span>
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

    {{-- Tabel Medication --}}
    <div class="table-wrap pt-wrap" style="overflow-x: auto">
        <table class="table pt-table">
            <thead>
                <tr>
                    <th scope="col" class="c-ck" style="width: 44px; padding-right: 0">
                        <input
                            type="checkbox"
                            class="check"
                            id="medication-check-all"
                            onchange="selectAllRows(this)"
                            aria-label="Pilih semua baris"
                        />
                    </th>
                    <th scope="col" style="min-width: 260px">Nama Obat & Kekuatan</th>
                    <th scope="col" style="min-width: 160px">Kode KFA (Kemenkes)</th>
                    <th scope="col" style="min-width: 150px">Bentuk Sediaan</th>
                    <th scope="col" style="min-width: 160px">Golongan Obat</th>
                    <th scope="col" style="min-width: 180px">Produsen / Pabrik</th>
                    <th scope="col" style="min-width: 130px">Status KFA</th>
                    <th scope="col" style="text-align: right; width: 90px; padding-left: 0">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medications as $m)
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
                                        font-size: 13px;
                                        font-weight: 700;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        flex-shrink: 0;
                                    "
                                >
                                    <svg class="ico" viewBox="0 0 24 24" style="width: 16px; height: 16px; stroke: currentColor;"><path d="M10.5 20.5 3.5 13.5a5 5 0 0 1 7-7l7 7a5 5 0 0 1-7 7Z"/><path d="m8.5 8.5 7 7"/></svg>
                                </span>
                                <div>
                                    <b style="font-weight: 650; color: var(--text); font-size: 13.5px;">
                                        {{ $m['name'] }}
                                    </b>
                                    <small style="color: var(--muted); font-size: 12px; display: block; margin-top: 1px;">
                                        Kekuatan: {{ $m['strength'] }} · Ref: {{ $m['id'] }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-family: monospace; font-size: 12.5px; font-weight: 700; color: var(--primary);">
                                {{ $m['kfa_code'] }}
                            </div>
                            <div style="font-size: 11px; color: var(--muted);">KFA PoP v1</div>
                        </td>
                        <td>
                            <span class="badge" style="background: var(--surface-2); border: 1px solid var(--line); color: var(--text); font-size: 11.5px; padding: 2px 8px; border-radius: 6px;">
                                {{ $m['dose_form'] }} ({{ $m['dose_form_code'] }})
                            </span>
                        </td>
                        <td>
                            @if($m['category_tone'] === 'green')
                                <span class="badge" style="background: rgba(52, 199, 89, 0.12); color: #1e7e34; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 999px;">
                                    {{ $m['category'] }}
                                </span>
                            @else
                                <span class="badge" style="background: rgba(255, 59, 48, 0.1); color: #dc2626; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 999px;">
                                    {{ $m['category'] }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <div style="font-size: 13px; font-weight: 550; color: var(--text);">{{ $m['manufacturer'] }}</div>
                        </td>
                        <td>
                            <span class="badge" style="background: rgba(52, 199, 89, 0.12); color: #1e7e34; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 999px;">
                                {{ $m['status_label'] }}
                            </span>
                        </td>
                        <td style="text-align: right; padding-right: 14px;">
                            <button
                                type="button"
                                class="btn btn--xs btn--ghost"
                                onclick="copyKfa('{{ $m['kfa_code'] }}', event)"
                                title="Salin Kode KFA"
                                style="padding: 4px 8px; font-size: 11px;"
                            >
                                Salin KFA
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
        const master = document.getElementById('medication-check-all');
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
    function copyKfa(kfa, e) {
        e.stopPropagation();
        navigator.clipboard.writeText(kfa).then(() => {
            alert('Kode KFA ' + kfa + ' disalin!');
        });
    }
    function syncMedicationNow(btn) {
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

