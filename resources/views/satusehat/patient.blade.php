@extends('layouts.app')

@section('content')
<div class="mgmt-page">
    <header class="head" style="margin-bottom: 24px">
        <div class="head__lead">
            <div>
                <p class="head__eyebrow" style="display: flex; align-items: center; gap: 6px">
                    <a href="{{ route('dashboard.index') }}" style="color: var(--muted); text-decoration: none">Dashboard</a>
                    <span style="color: var(--faint)">/</span>
                    <span>Satu Sehat ReST API</span>
                    <span style="color: var(--faint)">/</span>
                    <span style="color: var(--text); font-weight: 600">Patient</span>
                </p>
                <h1 class="head__title">Data <em>Pasien (Patient)</em></h1>
            </div>
        </div>
        <div class="head__actions" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap">
            <a href="{{ route('setting.api-key.index') }}" class="btn btn--ghost" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px">
                <svg class="ico" viewBox="0 0 24 24" style="width:15px;height:15px;"><path d="m21 2-2 2m-1.5 1.5 1.5 1.5-2 2-1.5-1.5M15.5 7.5 14 9l2 2 1.5-1.5M10.5 13.5a5 5 0 1 1-7-7 5 5 0 0 1 7 7Z"/></svg>
                Konfigurasi API
            </a>
            <button type="button" id="btn-copy-json" class="btn btn--primary" onclick="copyPatientJson()" style="display: none; inline-flex; align-items: center; gap: 6px; font-size: 13px">
                <svg class="ico" viewBox="0 0 24 24" style="width:15px;height:15px;"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                <span>Salin JSON</span>
            </button>
        </div>
    </header>

    {{-- ── Card Search Form ── --}}
    <section class="card" style="
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 18px;
        box-shadow: var(--shadow-sm);
        padding: 20px 24px;
        margin-bottom: 24px;
    ">
        <form method="GET" action="{{ route('satusehat.patient.index') }}" id="search-patient-form" novalidate>
            <div style="display: flex; align-items: stretch; max-width: 640px; border: 1px solid var(--line-2); border-radius: 10px; background: var(--surface); overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <select name="type" id="search-type" style="
                    border: none;
                    background: var(--surface-2);
                    color: var(--text);
                    font-size: 13.5px;
                    font-weight: 600;
                    padding: 0 14px;
                    height: 42px;
                    border-right: 1px solid var(--line-2);
                    outline: none;
                    cursor: pointer;
                ">
                    <option value="id" {{ strtolower($searchType ?? 'nik') === 'id' ? 'selected' : '' }}>ID</option>
                    <option value="nik" {{ strtolower($searchType ?? 'nik') !== 'id' ? 'selected' : '' }}>NIK</option>
                </select>
                <input
                    type="text"
                    name="q"
                    id="search-input"
                    value="{{ $searchQuery ?? '' }}"
                    placeholder="{{ strtolower($searchType ?? 'nik') === 'id' ? 'Masukkan ID Pasien (mis: P00702846568)' : 'Masukkan NIK Pasien (mis: 3509160107400100)' }}"
                    style="
                        flex: 1;
                        border: none;
                        outline: none;
                        background: transparent;
                        color: var(--text);
                        font-size: 13.5px;
                        padding: 0 14px;
                        height: 42px;
                    "
                    autocomplete="off"
                />
                <button type="submit" id="btn-search" style="
                    border: none;
                    background: var(--primary);
                    color: #fff;
                    font-size: 13.5px;
                    font-weight: 600;
                    padding: 0 20px;
                    height: 42px;
                    cursor: pointer;
                ">
                    Cari
                </button>
            </div>
        </form>
    </section>

    {{-- ── Loading State ── --}}
    <section id="loading-section" class="card" style="
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 18px;
        box-shadow: var(--shadow-sm);
        padding: 40px 20px;
        text-align: center;
        display: none;
    ">
        <div class="loader" style="
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 4px solid color-mix(in srgb, var(--primary) 25%, transparent);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 12px;
        "></div>
        <p style="color: var(--muted); font-size: 14px; font-weight: 600; margin: 0;">Mengambil data pasien dari Satu Sehat Kemenkes...</p>
        <p style="color: var(--faint); font-size: 12px; margin-top: 6px;">Mohon tunggu sebentar</p>
    </section>

    {{-- ── Empty / Initial State ── --}}
    <section id="empty-section" class="card" style="
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 18px;
        box-shadow: var(--shadow-sm);
        padding: 40px 20px;
        text-align: center;
    ">
        <p style="color: var(--muted); font-size: 14px; margin: 0;">Silakan masukkan ID atau NIK pasien untuk melakukan pencarian ke Satu Sehat Kemenkes.</p>
    </section>

    {{-- ── Result State ── --}}
    <section id="result-section" class="card" style="
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 18px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
        display: none;
    ">
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 22px; border-bottom: 1px solid var(--line-2);">
            <div>
                <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: var(--muted); letter-spacing: 0.4px;">Hasil Pencarian</span>
                <p id="result-summary" style="color: var(--text); font-size: 13.5px; margin: 4px 0 0 0;"></p>
            </div>
            <button type="button" id="btn-toggle-format" onclick="toggleFormat()" style="
                border: 1px solid var(--line-2);
                background: var(--surface-2);
                color: var(--text);
                font-size: 12px;
                padding: 6px 14px;
                border-radius: 8px;
                cursor: pointer;
            ">Tampilan Compact</button>
        </div>
        <div style="padding: 20px 22px;">
            <pre id="json-viewer" style="
                margin: 0;
                padding: 18px 20px;
                border-radius: 12px;
                background: var(--surface-2);
                border: 1px solid var(--line);
                font-family: 'Geist Mono', ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
                font-size: 12.5px;
                line-height: 1.6;
                color: var(--text);
                overflow-x: auto;
                white-space: pre-wrap;
                word-break: break-all;
            "><code id="json-code">{{ $rawJsonString ?? '' }}</code></pre>
        </div>
    </section>

    {{-- ── Error State ── --}}
    <section id="error-section" class="card" style="
        background: color-mix(in srgb, var(--bad) 8%, transparent);
        border: 1px solid color-mix(in srgb, var(--bad) 25%, transparent);
        border-radius: 18px;
        box-shadow: var(--shadow-sm);
        padding: 24px 20px;
        text-align: center;
        display: none;
    ">
        <p style="color: var(--bad); font-size: 14px; font-weight: 600; margin: 0;"></p>
    </section>
</div>

@push('scripts')
<script>
    let isPretty = true;
    let prettyJson = @json($rawJsonString ?? '');
    let compactJson = @json($compactJsonString ?? '');
    let hasResult = @json($jsonResult !== null);

    // Inisialisasi state saat halaman dimuat (non-AJAX, hasil sudah ada dari server)
    if (hasResult && prettyJson) {
        document.getElementById('empty-section').style.display = 'none';
        document.getElementById('result-section').style.display = 'block';
        document.getElementById('btn-copy-json').style.display = 'inline-flex';
        document.getElementById('json-code').textContent = prettyJson;
        updateSummary();
    }

    function updateSummary() {
        try {
            const data = JSON.parse(prettyJson);
            const summary = document.getElementById('result-summary');
            if (!summary) return;
            
            if (data.resourceType === 'Bundle') {
                summary.textContent = 'Ditemukan ' + (data.total || 0) + ' data pasien.';
            } else if (data.resourceType === 'Patient') {
                const name = (data.name && data.name[0]) ? (data.name[0].text || '') : '';
                summary.textContent = 'Data pasien: ' + (name || data.id) + ' (ID: ' + data.id + ')';
            } else {
                summary.textContent = 'Data diterima dari Satu Sehat Kemenkes.';
            }
        } catch (e) {
            document.getElementById('result-summary').textContent = 'Data diterima dari Satu Sehat Kemenkes.';
        }
    }

    function toggleFormat() {
        const viewer = document.getElementById('json-viewer');
        const btn = document.getElementById('btn-toggle-format');
        const code = document.getElementById('json-code');
        if (!viewer || !code) return;

        if (isPretty) {
            code.textContent = compactJson;
            btn.textContent = 'Tampilan Pretty';
            isPretty = false;
        } else {
            code.textContent = prettyJson;
            btn.textContent = 'Tampilan Compact';
            isPretty = true;
        }
    }

    function copyPatientJson() {
        const text = isPretty ? prettyJson : compactJson;
        if (!text) return;
        navigator.clipboard.writeText(text).then(function() {
            alert('JSON Patient berhasil disalin ke clipboard!');
        }).catch(function() {
            const ta = document.createElement('textarea');
            ta.value = text;
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
            alert('JSON Patient berhasil disalin ke clipboard!');
        });
    }

    // Dynamic placeholder saat ganti tipe ID / NIK
    const searchTypeSelect = document.getElementById('search-type');
    const searchInput = document.getElementById('search-input');
    if (searchTypeSelect && searchInput) {
        searchTypeSelect.addEventListener('change', function() {
            if (this.value === 'id') {
                searchInput.placeholder = 'Masukkan ID Pasien (mis: P00702846568)';
                if (searchInput.value === '3509160107400100') {
                    searchInput.value = 'P00702846568';
                }
            } else {
                searchInput.placeholder = 'Masukkan NIK Pasien (mis: 3509160107400100)';
                if (searchInput.value === 'P00702846568') {
                    searchInput.value = '3509160107400100';
                }
            }
        });
    }

    // --- AJAX Search with Loading Animation ---
    const form = document.getElementById('search-patient-form');
    const btnSearch = document.getElementById('btn-search');
    const btnSearchOriginal = btnSearch ? btnSearch.innerHTML : '';
    const loadingSection = document.getElementById('loading-section');
    const emptySection = document.getElementById('empty-section');
    const resultSection = document.getElementById('result-section');
    const errorSection = document.getElementById('error-section');
    const jsonCode = document.getElementById('json-code');
    const btnCopy = document.getElementById('btn-copy-json');
    const errorParagraph = errorSection ? errorSection.querySelector('p') : null;

    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(form);
            const type = formData.get('type') || 'nik';
            const q = formData.get('q') || '';

            if (!q.trim()) {
                alert('Silakan masukkan ID atau NIK pasien terlebih dahulu.');
                return;
            }

            // Tampilkan loading, sembunyikan lainnya
            btnSearch.disabled = true;
            btnSearch.innerHTML = '<span style="display:inline-flex;align-items:center;gap:6px;"><svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;animation:spin 1s linear infinite;"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg> Mencari...</span>';

            emptySection.style.display = 'none';
            resultSection.style.display = 'none';
            errorSection.style.display = 'none';
            loadingSection.style.display = 'block';

            try {
                const url = form.getAttribute('action') + '?type=' + encodeURIComponent(type) + '&q=' + encodeURIComponent(q.trim());
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                });

                const data = await response.json();

                loadingSection.style.display = 'none';
                btnSearch.disabled = false;
                btnSearch.innerHTML = btnSearchOriginal;

                if (data.success && data.jsonResult) {
                    prettyJson = data.rawJsonString;
                    compactJson = data.compactJsonString;
                    hasResult = true;

                    resultSection.style.display = 'block';
                    btnCopy.style.display = 'inline-flex';
                    jsonCode.textContent = prettyJson;
                    updateSummary();
                } else {
                    errorSection.style.display = 'block';
                    if (errorParagraph) {
                        errorParagraph.textContent = data.error || 'Gagal mengambil data pasien. Pastikan konfigurasi API Key sudah benar.';
                    }
                }
            } catch (err) {
                loadingSection.style.display = 'none';
                btnSearch.disabled = false;
                btnSearch.innerHTML = btnSearchOriginal;
                errorSection.style.display = 'block';
                if (errorParagraph) {
                    errorParagraph.textContent = 'Terjadi kesalahan saat terhubung ke Satu Sehat Kemenkes.';
                }
            }
        });
    }
</script>

<style>
    @keyframes spin {
        100% { transform: rotate(360deg); }
    }
</style>
@endpush
@endsection
