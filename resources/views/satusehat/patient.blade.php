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
            @if($rawJsonString)
                <button type="button" class="btn btn--primary" onclick="copyPatientJson()" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px">
                    <svg class="ico" viewBox="0 0 24 24" style="width:15px;height:15px;"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                    <span>Salin JSON</span>
                </button>
            @endif
        </div>
    </header>

    {{-- ── Card Search Form (Dropdown ID / NIK + Textfield + Search Button) ── --}}
    <section class="card" style="
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 18px;
        box-shadow: var(--shadow-sm);
        padding: 20px 24px;
        margin-bottom: 24px;
    ">
        <form method="GET" action="{{ route('satusehat.patient.index') }}" id="search-patient-form">
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
                    <option value="id" {{ strtolower($searchType) === 'id' ? 'selected' : '' }}>ID</option>
                    <option value="nik" {{ strtolower($searchType) === 'nik' ? 'selected' : '' }}>NIK</option>
                </select>
                <input
                    type="text"
                    name="q"
                    id="search-input"
                    value="{{ $searchQuery }}"
                    placeholder="{{ strtolower($searchType) === 'id' ? 'Masukkan ID Pasien (mis: P00702846568)' : 'Masukkan NIK Pasien (mis: 3509160107400100)' }}"
                    style="
                        flex: 1;
                        border: none;
                        padding: 0 16px;
                        font-size: 13.5px;
                        color: var(--text);
                        background: transparent;
                        outline: none;
                        height: 42px;
                    "
                    required
                />
                <button type="submit" class="btn btn--primary" style="
                    border-radius: 0;
                    height: 42px;
                    padding: 0 20px;
                    font-size: 13.5px;
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                ">
                    <svg class="ico" viewBox="0 0 24 24" style="width:15px;height:15px;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <span>Cari</span>
                </button>
            </div>
        </form>
    </section>

    {{-- ── Card Hasil Response JSON ── --}}
    @if($jsonResult)
        <section class="card" style="
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            margin-bottom: 24px;
        ">
            <div style="
                padding: 16px 22px;
                border-bottom: 1px solid var(--line);
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 12px;
                background: var(--surface-2);
            ">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 32px;
                        height: 32px;
                        border-radius: 9px;
                        background: color-mix(in srgb, var(--primary) 14%, transparent);
                        color: var(--primary);
                        flex-shrink: 0;
                    ">
                        <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;stroke:var(--primary);">
                            <polyline points="16 18 22 12 16 6"/>
                            <polyline points="8 6 2 12 8 18"/>
                        </svg>
                    </span>
                    <div>
                        <h3 style="font-size: 14.5px; font-weight: 700; margin: 0; color: var(--text)">
                            FHIR R4 Patient Resource Response
                        </h3>
                        <p style="font-size: 12px; color: var(--muted); margin: 2px 0 0;">
                            Pencarian {{ strtoupper($searchType) }}: <b style="color:var(--text);font-family:monospace;">{{ $searchQuery }}</b>
                        </p>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <button type="button" class="btn btn--xs btn--ghost" id="btn-toggle-format" onclick="toggleFormat()" style="font-size: 12px; height: 30px; padding: 0 10px;">
                        Tampilan Compact
                    </button>
                    <button type="button" class="btn btn--xs btn--primary" onclick="copyPatientJson()" style="font-size: 12px; height: 30px; padding: 0 12px;">
                        Salin JSON
                    </button>
                </div>
            </div>

            <div style="padding: 20px 22px; background: var(--surface);">
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
                "><code>{{ $rawJsonString }}</code></pre>
            </div>
        </section>
    @else
        <section class="card" style="
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: var(--shadow-sm);
            padding: 40px 20px;
            text-align: center;
        ">
            <p style="color: var(--muted); font-size: 14px; margin: 0;">Silakan masukkan ID atau NIK pasien untuk melakukan pencarian ke Satu Sehat Kemenkes.</p>
        </section>
    @endif
</div>

@push('scripts')
<script>
    let isPretty = true;
    const prettyJson = @json($rawJsonString);
    const compactJson = @json($compactJsonString);

    function toggleFormat() {
        const viewer = document.getElementById('json-viewer');
        const btn = document.getElementById('btn-toggle-format');
        if (!viewer) return;

        if (isPretty) {
            viewer.querySelector('code').textContent = compactJson;
            btn.textContent = 'Tampilan Pretty';
            isPretty = false;
        } else {
            viewer.querySelector('code').textContent = prettyJson;
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
            // fallback
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
</script>
@endpush
@endsection

