@extends ('layouts.app')

@section ('content')
    <div class="mgmt-page">
        {{-- ── Header ─────────────────────────────────────────────── --}}
        <header class="head" style="margin-bottom: 24px">
            <div class="head__lead">
                <div>
                    <p class="head__eyebrow" style="display: flex; align-items: center; gap: 6px">
                        <a href="{{ route('dashboard.index') }}" style="color: var(--muted); text-decoration: none"
                            >Dashboard</a>
                        >
                        <span style="color: var(--faint)">/</span>
                        <span>Satu Sehat ReST API</span>
                        <span style="color: var(--faint)">/</span>
                        <span style="color: var(--text); font-weight: 600">Organization</span>
                    </p>
                    <h1 class="head__title">Data <em>Organisasi (Faskes)</em></h1>
                </div>
            </div>
        </header>

        {{-- ── Raw JSON FHIR R4 ── --}}
        <div id="fhir-json-card" class="card" style="background: var(--surface); border: 1px solid var(--line); border-radius: 18px; box-shadow: var(--shadow-sm); margin-top: 24px; overflow: hidden;">
            <div style="padding: 16px 24px; border-bottom: 1px solid var(--line-2); display: flex; align-items: center; justify-content: space-between">
                <h2 style="font-size: 16px; font-weight: 700; color: var(--text); margin: 0">Resource FHIR R4 — Organization</h2>
                <button type="button" class="btn btn--ghost btn--xs" onclick="copyOrgJson()" style="padding: 6px 14px; font-size: 12.5px">Salin JSON</button>
            </div>
            <div style="padding: 24px">
                <textarea id="raw_fhir_json" rows="28" readonly style="width: 100%; box-sizing: border-box; padding: 16px; border-radius: 12px; border: 1px solid var(--line-2); background: var(--surface-2); color: var(--text); font-family: 'JetBrains Mono', 'Fira Code', 'Courier New', monospace; font-size: 12px; line-height: 1.65; outline: none; resize: vertical; word-break: break-all">{{ $rawJsonString ?? '-' }}</textarea>
            </div>
        </div>

    </div>

    @push ('scripts')
        <script>
            function copyOrgJson() {
                const ta = document.getElementById('raw_fhir_json');
                if (!ta || !ta.value) return;
                navigator.clipboard.writeText(ta.value).then(() => {
                    showToast('JSON Organisasi tersalin ke clipboard!');
                });
            }

            function copyToClipboard(text, message) {
                if (!text) return;
                navigator.clipboard.writeText(text).then(() => {
                    showToast(message || 'Tersalin ke clipboard!');
                });
            }

            function showToast(msg) {
                const t = document.createElement('div');
                t.style.cssText = 'position:fixed;bottom:24px;right:24px;background:var(--primary);color:#fff;padding:10px 20px;border-radius:10px;font-size:13px;font-weight:600;box-shadow:0 8px 24px rgba(0,0,0,0.18);z-index:9999;display:flex;align-items:center;gap:8px;';
                t.innerHTML = '<svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:#fff;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;"><polyline points="20 6 9 17 4 12"/></svg> ' + msg;
                document.body.appendChild(t);
                setTimeout(() => { t.style.transition = 'opacity 0.3s'; t.style.opacity = '0'; setTimeout(() => t.remove(), 300); }, 2200);
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
