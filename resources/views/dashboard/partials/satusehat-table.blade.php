{{--
    View: kartu "Pengiriman Data Satu Sehat"
    Data diisi via AJAX dari route dashboard.data setelah halaman render,
    sehingga halaman langsung muncul dengan stats 0 dan tabel loading.
--}}
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
                <svg class="ico" viewBox="0 0 24 24" style="width: 20px; height: 20px; stroke: #1e7e34">
                    <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                </svg>
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
                    >Sync Otomatis</span>
                </h2>
                <p style="font-size: 12.5px; color: var(--muted); margin: 2px 0 0 0">
                    Monitoring integrasi data Encounter dan Diagnosa SIMRS ke Platform SATUSEHAT Kemenkes
                </p>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 8px">
            <a
                href="{{ Route::has('setting.api-key.index') ? route('setting.api-key.index') : '#' }}"
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
                <svg class="ico" viewBox="0 0 24 24" style="width: 14px; height: 14px">
                    <path d="m21 2-2 2m-1.5 1.5 1.5 1.5-2 2-1.5-1.5M15.5 7.5 14 9l2 2 1.5-1.5M10.5 13.5a5 5 0 1 1-7-7 5 5 0 0 1 7 7Z" />
                </svg>
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
                <svg class="ico" viewBox="0 0 24 24" style="width: 14px; height: 14px">
                    <polyline points="23 4 23 10 17 10" />
                    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                </svg>
                <span>Sinkronisasi Sekarang</span>
            </button>
        </div>
    </div>

    {{-- Ringkasan Metrics Card (awal 0, di-animate via JS) --}}
    <div
        id="stats-card"
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
            <div style="font-size: 10.5px; font-weight: 700; text-transform: uppercase; color: var(--muted); letter-spacing: 0.5px; margin-bottom: 6px">Encounter · 60 Hari</div>
            <div style="font-size: 22px; font-weight: 800; color: var(--text); display: flex; align-items: baseline; gap: 5px">
                <span class="tnum counter" id="stat-encounter">0</span>
                <small style="font-size: 11px; font-weight: 600; color: #1e7e34">Rekam</small>
            </div>
        </div>
        <div style="flex: 1; padding: 14px 18px; border-right: 1px solid var(--line)">
            <div style="font-size: 10.5px; font-weight: 700; text-transform: uppercase; color: var(--muted); letter-spacing: 0.5px; margin-bottom: 6px">Diagnosa · 60 Hari</div>
            <div style="font-size: 22px; font-weight: 800; color: var(--text); display: flex; align-items: baseline; gap: 5px">
                <span class="tnum counter" id="stat-diagnosa">0</span>
                <small style="font-size: 11px; font-weight: 600; color: #1e7e34">ICD-10</small>
            </div>
        </div>
        <div style="flex: 1; padding: 14px 18px; border-right: 1px solid var(--line)">
            <div style="font-size: 10.5px; font-weight: 700; text-transform: uppercase; color: var(--muted); letter-spacing: 0.5px; margin-bottom: 6px">Hari Tercatat</div>
            <div style="font-size: 22px; font-weight: 800; color: var(--text); display: flex; align-items: baseline; gap: 5px">
                <span class="tnum counter" id="stat-hari">0</span>
                <small style="font-size: 11px; font-weight: 500; color: var(--muted)">Hari</small>
            </div>
        </div>
        <div style="flex: 1; padding: 14px 18px">
            <div style="font-size: 10.5px; font-weight: 700; text-transform: uppercase; color: var(--muted); letter-spacing: 0.5px; margin-bottom: 6px">Sinkronisasi Terakhir</div>
            <div style="font-size: 15px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 7px; margin-top: 3px">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #34c759; box-shadow: 0 0 0 3px rgba(52, 199, 89, 0.2); flex-shrink: 0"></span>
                <span id="stat-sync">-</span>
            </div>
        </div>
    </div>

    {{-- Meta bar --}}
    <div class="pt-meta" style="min-height: 40px; color: var(--muted); justify-content: space-between; align-items: center; gap: 10px; padding: 4px 6px 8px; font-size: 12.5px; display: flex">
        <span id="meta-count">Daftar Terkirim · Menampilkan <b>0</b> dari <b>0</b> log</span>
        <button type="button" class="btn btn--xs btn--ghost" onclick="toggleSelectAllRows()" style="display: inline-flex; align-items: center; gap: 6px">
            <svg class="ico" viewBox="0 0 24 24" style="width: 14px; height: 14px"><path d="m5 12.5 4.5 4.5L19 7.5"></path></svg>
            <span>Pilih semua baris</span>
        </button>
    </div>

    {{-- Tabel Pengiriman Data --}}
    <div id="table-container" style="overflow-x: auto">
        {{-- Loading --}}
        <div id="table-loading" style="padding: 40px 16px; text-align: center">
            <div style="display: inline-block; width: 40px; height: 40px; border: 4px solid color-mix(in srgb, var(--primary) 25%, transparent); border-top-color: var(--primary); border-radius: 50%; animation: spin 1s linear infinite; margin-bottom: 12px"></div>
            <p style="color: var(--muted); font-size: 14px; font-weight: 600; margin: 0">Memuat data pengiriman...</p>
            <p style="color: var(--muted); font-size: 12px; margin-top: 6px; opacity: .8">Mohon tunggu sebentar</p>
        </div>

        {{-- Tabel (disembunyikan dulu, tampil setelah data siap) --}}
        <table id="pt-table" class="table pt-table" style="display: none">
            <thead>
                <tr>
                    <th scope="col" class="c-ck" style="width: 44px; padding-right: 0">
                        <input type="checkbox" class="check" id="satusehat-check-all" onchange="selectAllSatuRows(this)" aria-label="Pilih semua baris" />
                    </th>
                    <th scope="col" style="min-width: 220px">
                        <button type="button" style="color: inherit; align-items: center; gap: 6px; font-weight: 650; display: inline-flex">
                            Tanggal
                            <span class="pt-sorti is-on" style="display: inline-grid"><svg class="ico" viewBox="0 0 24 24" style="width: 13px; height: 13px"><path d="m6 9.5 6 6 6-6"></path></svg></span>
                        </button>
                    </th>
                    <th scope="col" style="min-width: 200px">Jumlah Encounter</th>
                    <th scope="col" style="min-width: 180px">Jumlah Diagnosa</th>
                    <th scope="col" style="width: 170px">Status</th>
                </tr>
            </thead>
            <tbody id="pt-table-body"></tbody>
        </table>

        {{-- Empty / error state --}}
        <div id="table-empty" style="padding: 40px 16px; text-align: center; display: none">
            <p style="color: var(--muted); font-size: 14px; margin: 0">Belum ada riwayat pengiriman data SatuSehat.</p>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function syncSatuSehatNow(btn) {
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML =
            '<svg class="ico" viewBox="0 0 24 24" style="width: 14px; height: 14px; animation: spin 1s linear infinite;"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg><span>Menghubungkan...</span>';

        // Masih simulasi. Ganti dengan fetch() ke endpoint sinkronisasi yang sebenarnya.
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
        document.querySelectorAll('.satusehat-row-check').forEach((c) => {
            c.checked = master.checked;
            const tr = c.closest('tr');
            if (tr) tr.classList.toggle('is-sel', master.checked);
        });
    }

    function toggleSelectAllRows() {
        const master = document.getElementById('satusehat-check-all');
        if (master) {
            master.checked = !master.checked;
            selectAllSatuRows(master);
        }
    }

    function toggleRowSelect(tr, event) {
        if (event.target.tagName === 'INPUT' || event.target.closest('button')) return;
        const ck = tr.querySelector('.satusehat-row-check');
        if (ck) {
            ck.checked = !ck.checked;
            tr.classList.toggle('is-sel', ck.checked);
        }
    }

    // --- Helper ---
    function formatNumber(n) {
        return Number(n).toLocaleString('id-ID'); // 12345 -> 12.345
    }

    function escapeHtml(str) {
        return String(str).replace(/[&<>"']/g, (c) => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
        }[c]));
    }

    function animateCounter(el, target, duration = 1200) {
        target = Number(target) || 0;
        const startTime = performance.now();

        function step(now) {
            const progress = Math.min((now - startTime) / duration, 1);
            const ease = 1 - Math.pow(1 - progress, 3);
            el.textContent = formatNumber(Math.floor(target * ease));
            if (progress < 1) requestAnimationFrame(step);
            else el.textContent = formatNumber(target);
        }

        requestAnimationFrame(step);
    }

    function renderRows(rows) {
        return rows.map((row, i) => {
            const encounter = Number(row.encounter) || 0;   // cast: SUM() dari MySQL bisa berupa string
            const diagnosa  = Number(row.diagnosa) || 0;
            const statusLabel = (encounter + diagnosa) > 0 ? 'Terkirim' : 'Pending';
            const delay = Math.min(i, 14) * 30;

            return `
                <tr class="satusehat-row" style="cursor: pointer; animation-delay: ${delay}ms" onclick="toggleRowSelect(this, event)">
                    <td class="c-ck" style="padding-right: 0">
                        <input type="checkbox" class="check satusehat-row-check" onclick="event.stopPropagation()" />
                    </td>
                    <td style="font-weight: 600; color: var(--text); font-family: monospace">${escapeHtml(row.tanggal)}</td>
                    <td class="tnum" style="color: var(--text); font-weight: 700">${formatNumber(encounter)}</td>
                    <td class="tnum" style="color: var(--text); font-weight: 700">${formatNumber(diagnosa)}</td>
                    <td>
                        <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 650; color: #1e7e34">
                            <svg class="ico" viewBox="0 0 24 24" style="width: 13px; height: 13px; stroke: #1e7e34"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>${statusLabel}</span>
                        </span>
                    </td>
                </tr>`;
        }).join('');
    }

    async function loadDashboardData() {
        const loading = document.getElementById('table-loading');
        const table   = document.getElementById('pt-table');
        const empty   = document.getElementById('table-empty');
        const tbody   = document.getElementById('pt-table-body');
        const meta    = document.getElementById('meta-count');

        try {
            const response = await fetch(@json(route('dashboard.data')), {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin',
            });

            if (!response.ok) throw new Error('HTTP ' + response.status);

            const data = await response.json();
            const rows = data.daftar_terkirim || [];

            animateCounter(document.getElementById('stat-encounter'), data.total_encounter);
            animateCounter(document.getElementById('stat-diagnosa'), data.total_diagnosa);
            animateCounter(document.getElementById('stat-hari'), data.hari_tercatat);
            document.getElementById('stat-sync').textContent = data.sinkronisasi_terakhir || '-';

            meta.innerHTML = 'Daftar Terkirim · Menampilkan <b>' + rows.length + '</b> dari <b>' + rows.length + '</b> log';

            loading.style.display = 'none';

            if (rows.length > 0) {
                tbody.innerHTML = renderRows(rows);
                empty.style.display = 'none';
                table.style.display = 'table';
            } else {
                table.style.display = 'none';
                empty.style.display = 'block';
            }
        } catch (err) {
            console.error('Gagal memuat data dashboard:', err);
            loading.style.display = 'none';
            table.style.display = 'none';
            empty.style.display = 'block';
            empty.innerHTML = '<p style="color: #d93025; font-size: 14px; font-weight: 600; margin: 0">Gagal memuat data. Silakan muat ulang halaman.</p>';
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadDashboardData);
    } else {
        loadDashboardData();
    }
</script>

<style>
    @keyframes spin {
        100% { transform: rotate(360deg); }
    }
    @keyframes rowIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: none; }
    }
    .satusehat-row {
        animation: rowIn .4s ease-out both;
    }
    @media (prefers-reduced-motion: reduce) {
        .satusehat-row { animation: none; }
    }
    .table tbody tr.is-sel {
        background: color-mix(in srgb, var(--primary) 7%, transparent) !important;
    }
    .table tbody tr.is-sel:hover {
        background: color-mix(in srgb, var(--primary) 10%, transparent) !important;
    }
</style>
@endpush