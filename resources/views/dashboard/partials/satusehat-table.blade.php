<section
    class="card td-satusehat"
    id="td-satusehat"
    aria-labelledby="td-satusehat-t"
    style="
        margin-top: 18px;
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
                <svg class="ico" viewBox="0 0 24 24" style="width: 20px; height: 20px; stroke: #1e7e34;"><path d="M22 12h-4l-3 9L9 3l-3 9H2" /></svg>
            </div>
            <div>
                <h2
                    class="card__title"
                    id="td-satusehat-t"
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
                    Pengiriman Data Satu Sehat
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
                        >Sync Otomatis</span
                    >
                </h2>
                <p style="
                        font-size: 12.5px;
                        color: var(--muted);
                        margin: 2px 0 0 0;
                    ">Monitoring integrasi data Encounter dan Diagnosa SIMRS ke Platform SATUSEHAT Kemenkes</p>
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
                onclick="syncSatuSehatNow(this)"
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
                Total Encounter
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
                <span class="tnum">{{
                    number_format(
                        $satusehatSummary['total_encounter'] ?? 0,
                    )
                }}</span>
                <small style="font-size: 11px; font-weight: 600; color: #1e7e34">Rekam</small>
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
                Total Diagnosa
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
                <span class="tnum">{{
                    number_format(
                        $satusehatSummary['total_diagnosa'] ?? 0,
                    )
                }}</span>
                <small style="font-size: 11px; font-weight: 600; color: #1e7e34">ICD-10</small>
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
                Hari Tercatat
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
                <span class="tnum">{{ $satusehatSummary['days_count'] ?? 16 }}</span>
                <small style="font-size: 11px; font-weight: 500; color: var(--muted)">Hari</small>
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
                {{ $satusehatSummary['last_sync'] ?? date('d M Y') }}
            </div>
        </div>
    </div>

    {{-- Meta bar persis seperti patients table --}}
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
        <span data-shown=""
            >Daftar Terkirim · Menampilkan <b>{{ $satusehatLogs->count() }}</b> dari
            <b>{{ $satusehatLogs->count() }}</b> log</span
        >
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

    {{-- Tabel Pengiriman Data Menggunakan Format Table Patients --}}
    <div class="table-wrap pt-wrap" style="overflow-x: auto">
        <table class="table pt-table">
            <thead>
                <tr>
                    <th scope="col" class="c-ck" style="width: 44px; padding-right: 0">
                        <input
                            type="checkbox"
                            class="check"
                            id="satusehat-check-all"
                            onchange="selectAllSatuRows(this)"
                            aria-label="Pilih semua baris"
                        />
                    </th>
                    <th scope="col" style="min-width: 220px">
                        <button
                            type="button"
                            style="
                                color: inherit;
                                align-items: center;
                                gap: 6px;
                                font-weight: 650;
                                display: inline-flex;
                            "
                        >
                            Tanggal
                            <span class="pt-sorti is-on" style="display: inline-grid">
                                <svg class="ico" viewBox="0 0 24 24" style="width: 13px; height: 13px;"><path d="m6 9.5 6 6 6-6"></path></svg>
                            </span>
                        </button>
                    </th>
                    <th scope="col" style="min-width: 200px">
                        <button
                            type="button"
                            style="
                                color: inherit;
                                align-items: center;
                                gap: 6px;
                                font-weight: 650;
                                display: inline-flex;
                            "
                        >
                            Encounter
                            <span class="pt-sorti" style="display: inline-grid; opacity: 0.5">
                                <svg class="ico" viewBox="0 0 24 24" style="width: 13px; height: 13px;"><path d="m6 9.5 6 6 6-6"></path></svg>
                            </span>
                        </button>
                    </th>
                    <th scope="col" style="min-width: 200px">
                        <button
                            type="button"
                            style="
                                color: inherit;
                                align-items: center;
                                gap: 6px;
                                font-weight: 650;
                                display: inline-flex;
                            "
                        >
                            Diagnosa
                            <span class="pt-sorti" style="display: inline-grid; opacity: 0.5">
                                <svg class="ico" viewBox="0 0 24 24" style="width: 13px; height: 13px;"><path d="m6 9.5 6 6 6-6"></path></svg>
                            </span>
                        </button>
                    </th>
                    <th scope="col" style="min-width: 150px">Status Sinkron</th>
                    <th scope="col" style="text-align: right; width: 88px; padding-left: 0">
                        <span class="sr">Aksi</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($satusehatLogs as $log)
                    @php
                        $isWeekend = in_array($log->tanggal->dayOfWeek, [0, 6]);
                    @endphp
                    <tr style="cursor: pointer" onclick="toggleRowSelect(this, event)">
                        <td class="c-ck" style="width: 44px; padding-right: 0">
                            <input
                                type="checkbox"
                                class="check satusehat-row-check"
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
                                    {{ $log->tanggal->format('d') }}
                                </span>
                                <div>
                                    <b
                                        style="
                                            font-weight: 650;
                                            color: var(--text);
                                            font-family: monospace;
                                            font-size: 13.5px;
                                        "
                                    >
                                        {{ $log->tanggal->format('Y-m-d') }}
                                        @if ($log->tanggal->isToday())
                                            <span
                                                class="badge"
                                                style="
                                                    background: rgba(184, 51, 106, 0.12);
                                                    color: var(--primary);
                                                    font-size: 10.5px;
                                                    font-weight: 600;
                                                    padding: 1px 7px;
                                                    border-radius: 999px;
                                                    margin-left: 6px;
                                                    font-family: var(--font);
                                                "
                                                >Hari ini</span
                                            >
                                        @endif
                                    </b>
                                    <small
                                        style="color: var(--muted); font-size: 12px"
                                        >{{ $log->tanggal->locale('id')->isoFormat('dddd') }}</small
                                    >
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: baseline; gap: 8px">
                                <b
                                    class="tnum"
                                    style="font-size: 14px; font-weight: 700; color: var(--text)"
                                    >{{ number_format($log->encounter) }}</b
                                >
                                @if ($log->encounter > 500)
                                    <span
                                        class="spill spill--booked"
                                        style="
                                            background: rgba(52, 199, 89, 0.12);
                                            color: #1e7e34;
                                            font-size: 11px;
                                            font-weight: 600;
                                            padding: 2px 8px;
                                            border-radius: 999px;
                                        "
                                    >
                                        Optimal
                                    </span>
                                @elseif ($isWeekend)
                                    <span style="color: var(--muted); font-size: 11.5px">(Akhir Pekan)</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: baseline; gap: 8px">
                                <b
                                    class="tnum"
                                    style="font-size: 14px; font-weight: 700; color: var(--text)"
                                    >{{ number_format($log->diagnosa) }}</b
                                >
                                @if ($log->diagnosa > 1000)
                                    <span
                                        class="spill spill--booked"
                                        style="
                                            background: rgba(52, 199, 89, 0.12);
                                            color: #1e7e34;
                                            font-size: 11px;
                                            font-weight: 600;
                                            padding: 2px 8px;
                                            border-radius: 999px;
                                        "
                                    >
                                        Lengkap
                                    </span>
                                @elseif ($isWeekend)
                                    <span style="color: var(--muted); font-size: 11.5px">(Akhir Pekan)</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span
                                class="consent consent--opted-in"
                                style="
                                    white-space: nowrap;
                                    align-items: center;
                                    gap: 6px;
                                    font-size: 12px;
                                    font-weight: 650;
                                    display: inline-flex;
                                    color: #1e7e34;
                                "
                            >
                                <svg class="ico" viewBox="0 0 24 24" style="width: 15px; height: 15px; stroke: #1e7e34;"><polyline points="20 6 9 17 4 12" /></svg>
                                <span>Terkirim (200 OK)</span>
                            </span>
                        </td>
                        <td style="text-align: right; width: 88px; padding-left: 0">
                            <span class="pt-acts" style="gap: 2px; display: inline-flex">
                                <button
                                    type="button"
                                    class="ibtn ibtn--sm ibtn--plain"
                                    title="Kirim ulang tanggal ini"
                                    onclick="event.stopPropagation(); alert('Mengirim ulang data tanggal {{ $log->tanggal->format('Y-m-d') }} ke SatuSehat...')"
                                >
                                    <svg class="ico" viewBox="0 0 24 24" style="width: 15px; height: 15px;">
                                        <polyline points="23 4 23 10 17 10" />
                                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                                    </svg>
                                </button>
                                <button
                                    type="button"
                                    class="ibtn ibtn--sm ibtn--plain"
                                    title="Detail log"
                                    onclick="event.stopPropagation(); alert('Detail log tanggal {{ $log->tanggal->format('Y-m-d') }}:\nEncounter: {{ $log->encounter }}\nDiagnosa: {{ $log->diagnosa }}')"
                                >
                                    <svg class="ico" viewBox="0 0 24 24" style="width: 15px; height: 15px;">
                                        <circle cx="12" cy="12" r="1.5" />
                                        <circle cx="19" cy="12" r="1.5" />
                                        <circle cx="5" cy="12" r="1.5" />
                                    </svg>
                                </button>
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 36px 16px; text-align: center; color: var(--muted)">
                            Belum ada riwayat pengiriman data SatuSehat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@push ('scripts')
    <script>
        function syncSatuSehatNow(btn) {
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML =
                '<svg class="ico" viewBox="0 0 24 24" style="width: 14px; height: 14px; animation: spin 1s linear infinite;"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg><span>Menghubungkan...</span>';

            setTimeout(() => {
                btn.innerHTML =
                    '<svg class="ico" viewBox="0 0 24 24" style="width: 14px; height: 14px;"><polyline points="20 6 9 17 4 12"/></svg><span>Sinkron Selesai!</span>';
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 2500);
            }, 1500);
        }

        function selectAllSatuRows(master) {
            const checks = document.querySelectorAll('.satusehat-row-check');
            checks.forEach((c) => {
                c.checked = master.checked;
                const tr = c.closest('tr');
                if (tr) {
                    if (master.checked) tr.classList.add('is-sel');
                    else tr.classList.remove('is-sel');
                }
            });
        }

        function toggleSelectAllRows(btn) {
            const master = document.getElementById('satusehat-check-all');
            if (master) {
                master.checked = !master.checked;
                selectAllSatuRows(master);
            }
        }

        function toggleRowSelect(tr, event) {
            if (event.target.tagName === 'INPUT' || event.target.tagName === 'BUTTON' || event.target.closest('button'))
                return;
            const ck = tr.querySelector('.satusehat-row-check');
            if (ck) {
                ck.checked = !ck.checked;
                if (ck.checked) tr.classList.add('is-sel');
                else tr.classList.remove('is-sel');
            }
        }
    </script>
    <style>
        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
        .table tbody tr.is-sel {
            background: color-mix(in srgb, var(--primary) 7%, transparent) !important;
        }
        .table tbody tr.is-sel:hover {
            background: color-mix(in srgb, var(--primary) 10%, transparent) !important;
        }
    </style>
@endpush
