@extends ('layouts.app')

@section ('content')
    <div class="mgmt-page">
        {{-- ── Header ─────────────────────────────────────────────── --}}
        <header class="head" style="margin-bottom: 24px">
            <div class="head__lead">
                <div>
                    <p class="head__eyebrow" style="display: flex; align-items: center; gap: 6px">
                        <a href="{{ route('dashboard.index') }}" style="color: var(--muted); text-decoration: none"
                            >Dashboard</a
                        >
                        <span style="color: var(--faint)">/</span>
                        <span>Satu Sehat ReST API</span>
                        <span style="color: var(--faint)">/</span>
                        <span style="color: var(--text); font-weight: 600">Organization</span>
                    </p>
                    <h1 class="head__title">Data <em>Organisasi (Faskes)</em></h1>
                </div>
            </div>
            <div class="head__actions" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap">
                <form method="POST" action="{{ route('satusehat.organization.sync') }}" style="margin: 0">
                    @csrf
                    <button
                        type="submit"
                        class="btn btn--ghost"
                        style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px"
                    >
                        <svg class="ico" viewBox="0 0 24 24" style="width:15px;height:15px;">
                            <polyline points="23 4 23 10 17 10" />
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                        </svg>
                        Sinkronkan Satu Sehat
                    </button>
                </form>
                <button
                    type="button"
                    class="btn btn--ghost"
                    onclick="copyToClipboard('{{ $organization['id'] }}', 'Organization ID tersalin!')"
                    style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px"
                >
                    <svg class="ico" viewBox="0 0 24 24" style="width:15px;height:15px;">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2" />
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                    </svg>
                    Salin Org ID
                </button>
                <a
                    href="#fhir-json-card"
                    class="btn btn--primary"
                    style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; text-decoration: none"
                >
                    <svg class="ico" viewBox="0 0 24 24" style="width:15px;height:15px;">
                        <polyline points="16 18 22 12 16 6" />
                        <polyline points="8 6 2 12 8 18" />
                    </svg>
                    Lihat Raw JSON
                </a>
            </div>
        </header>

        {{-- Flash Message --}}
        @if (session('success'))
            <div
                style="
                    margin-bottom: 20px;
                    padding: 12px 18px;
                    background: color-mix(in srgb, var(--good) 14%, transparent);
                    border: 1px solid color-mix(in srgb, var(--good) 32%, transparent);
                    border-radius: 12px;
                    color: var(--good);
                    font-size: 14px;
                    font-weight: 600;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                "
            >
                <svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;stroke:var(--good);"><polyline points="20 6 9 17 4 12" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- ── Card Raw JSON Resource FHIR R4 (Data Asli Satu Sehat) ── --}}
        <div
            id="fhir-json-card"
            class="card"
            style="
                background: var(--surface);
                border: 1px solid var(--line);
                border-radius: 18px;
                box-shadow: var(--shadow-sm);
                overflow: hidden;
                margin-bottom: 18px;
            "
        >
            <div
                style="
                    padding: 20px 24px;
                    border-bottom: 1px solid var(--line);
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    flex-wrap: wrap;
                    gap: 10px;
                "
            >
                <div style="display: flex; align-items: center; gap: 10px">
                    <span
                        style="
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            width: 32px;
                            height: 32px;
                            border-radius: 9px;
                            background: color-mix(in srgb, var(--primary) 14%, transparent);
                            color: var(--primary);
                            flex-shrink: 0;
                        "
                    >
                        <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;stroke:var(--primary);">
                            <polyline points="16 18 22 12 16 6" />
                            <polyline points="8 6 2 12 8 18" />
                        </svg>
                    </span>
                    <div>
                        <h3 style="font-size: 15px; font-weight: 700; margin: 0; color: var(--text)">
                            FHIR R4 Organization Resource (JSON)
                        </h3>
                        <p style="
                                font-size: 12px;
                                color: var(--muted);
                                margin: 0;
                            ">Payload standar interoperabilitas Satu Sehat Kemenkes RI</p>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 8px">
                    <button
                        type="button"
                        class="btn btn--primary"
                        onclick="
                            copyToClipboard(
                                document.getElementById('raw_fhir_json').value,
                                'FHIR JSON berhasil disalin!',
                            )
                        "
                        style="
                            padding: 6px 14px;
                            height: 32px;
                            font-size: 12px;
                            border-radius: 8px;
                            display: inline-flex;
                            align-items: center;
                            gap: 6px;
                        "
                    >
                        <svg class="ico" viewBox="0 0 24 24" style="width:13px;height:13px;">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2" />
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                        </svg>
                        Salin JSON
                    </button>
                </div>
            </div>

            <div style="padding: 24px">
                <div style="position: relative">
                    <textarea
                        id="raw_fhir_json"
                        rows="30"
                        readonly
                        style="
                            width: 100%;
                            box-sizing: border-box;
                            padding: 16px;
                            border-radius: 12px;
                            border: 1px solid var(--line-2);
                            background: var(--surface-2);
                            color: var(--text);
                            font-family: 'JetBrains Mono', 'Fira Code', 'Courier New', monospace;
                            font-size: 12px;
                            line-height: 1.65;
                            outline: none;
                            resize: vertical;
                            word-break: break-all;
                        "
                        >{{ $rawJsonString }}</textarea
                    >
                </div>

                {{-- cURL Usage Box --}}
                <div
                    style="
                        margin-top: 18px;
                        background: var(--surface-2);
                        border: 1px solid var(--line);
                        border-radius: 12px;
                        padding: 14px 18px;
                    "
                >
                    <div
                        style="
                            font-size: 12px;
                            font-weight: 700;
                            color: var(--muted);
                            margin-bottom: 8px;
                            display: flex;
                            align-items: center;
                            gap: 6px;
                        "
                    >
                        <svg class="ico" viewBox="0 0 24 24" style="width:13px;height:13px;stroke:var(--muted);">
                            <polyline points="16 18 22 12 16 6" />
                            <polyline points="8 6 2 12 8 18" />
                        </svg>
                        Endpoint Satu Sehat FHIR ReST API (cURL)
                    </div>
                    <pre
                        style="
                            margin: 0;
                            font-family: 'JetBrains Mono', 'Fira Code', 'Courier New', monospace;
                            font-size: 11.5px;
                            color: var(--text);
                            white-space: pre-wrap;
                            line-height: 1.7;
                            overflow-x: auto;
                        "
                    >
curl -X GET "https://api-satusehat.kemkes.go.id/fhir-r4/v1/Organization/{{ $organization['id'] }}" \
  -H "Authorization: Bearer &lt;access_token&gt;" \
  -H "Content-Type: application/json"</pre
                    >
                </div>
            </div>
        </div>
    </div>

    @push ('scripts')
        <script>
            function copyToClipboard(text, message) {
                if (!text) return;
                navigator.clipboard.writeText(text).then(() => {
                    const toast = document.createElement('div');
                    toast.style.cssText =
                        'position:fixed;bottom:24px;right:24px;background:var(--primary);color:#fff;padding:10px 20px;border-radius:10px;font-size:13px;font-weight:600;box-shadow:0 8px 24px rgba(0,0,0,0.18);z-index:9999;display:flex;align-items:center;gap:8px;';
                    toast.innerHTML =
                        '<svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:#fff;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;"><polyline points="20 6 9 17 4 12"/></svg> ' +
                        (message || 'Tersalin ke clipboard!');
                    document.body.appendChild(toast);
                    setTimeout(() => {
                        toast.style.transition = 'opacity 0.3s';
                        toast.style.opacity = '0';
                        setTimeout(() => toast.remove(), 300);
                    }, 2200);
                });
            }
        </script>
        <style>
            @media (max-width: 960px) {
                .org-stats-grid {
                    grid-template-columns: repeat(2, 1fr) !important;
                }
                .org-details-grid {
                    grid-template-columns: 1fr !important;
                }
                .addr-codes-grid {
                    grid-template-columns: repeat(2, 1fr) !important;
                }
            }
            @media (max-width: 560px) {
                .org-stats-grid {
                    grid-template-columns: 1fr !important;
                }
                .addr-codes-grid {
                    grid-template-columns: 1fr !important;
                }
            }
        </style>
    @endpush
@endsection
