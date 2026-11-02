@extends ('layouts.app')

@section ('content')
<div class="mgmt-page">
    <header class="head" style="margin-bottom: 24px">
        <div class="head__lead">
            <div>
                <p class="head__eyebrow">Satu Sehat ReST API</p>
                <h1 class="head__title">OAuth2 <em>Access Token</em></h1>
            </div>
        </div>
        <div class="head__actions">
            <button
                type="button"
                class="btn btn--primary"
                onclick="copyToClipboard('access_token')"
                style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px"
            >
                <svg class="ico" viewBox="0 0 24 24" style="width: 15px; height: 15px">
                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2" />
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                </svg>
                Salin Token
            </button>
        </div>
    </header>

    {{-- Flash Message --}}
    @if (session('success'))
        <div
            style="
                margin-bottom: 18px;
                padding: 12px 18px;
                background: color-mix(in srgb, var(--good) 14%, transparent);
                border: 1px solid color-mix(in srgb, var(--good) 32%, transparent);
                border-radius: 10px;
                color: var(--good);
                font-size: 14px;
                font-weight: 550;
                display: flex;
                align-items: center;
                gap: 8px;
            "
        >
            <svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;"><polyline points="20 6 9 17 4 12" /></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Card Utama Token --}}
    <div
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
                gap: 10px;
                flex-wrap: wrap;
            "
        >
            <span
                style="
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 32px;
                    height: 32px;
                    border-radius: 9px;
                    background: var(--primary);
                    flex-shrink: 0;
                "
            >
                <svg class="ico" viewBox="0 0 24 24" style="width: 16px; height: 16px; stroke: #fff">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
            </span>
            <div>
                <h2 style="font-size: 15px; font-weight: 700; margin: 0; color: var(--text)">Access Token</h2>
                <p
                    style="font-size: 12px; color: var(--muted); margin: 0"
                >Bearer token untuk seluruh request ke FHIR API Kemenkes</p>
            </div>
            <span
                class="badge"
                style="
                    margin-left: auto;
                    background: rgba(52, 199, 89, 0.12);
                    color: #1e7e34;
                    font-size: 11px;
                    font-weight: 600;
                    padding: 3px 10px;
                    border-radius: 999px;
                    white-space: nowrap;
                "
                >Bearer Authentication</span
            >
        </div>

        <div style="padding: 24px">
            <label style="display: block; font-size: 12.5px; font-weight: 600; color: var(--text); margin-bottom: 8px">
                Access Token (Raw JWT) <span style="color: var(--primary)">*</span>
            </label>
            <div style="position: relative">
                <textarea
                    id="access_token"
                    rows="5"
                    readonly
                    style="
                        width: 100%;
                        box-sizing: border-box;
                        padding: 14px 110px 14px 16px;
                        border-radius: 12px;
                        border: 1px solid var(--line-2);
                        background: var(--surface-2);
                        color: var(--text);
                        font-family: 'JetBrains Mono', 'Fira Code', 'Courier New', monospace;
                        font-size: 12px;
                        line-height: 1;
                        outline: none;
                        resize: none;
                        word-break: break-all;
                    "
                    >{{ $token }}</textarea
                >
                <div
                    style="position: absolute; right: 10px; top: 12px; display: flex; flex-direction: column; gap: 6px"
                >
                    <button
                        type="button"
                        class="btn btn--primary"
                        onclick="copyToClipboard('access_token')"
                        style="
                            padding: 6px 12px;
                            height: 32px;
                            font-size: 12px;
                            border-radius: 8px;
                            display: inline-flex;
                            align-items: center;
                            gap: 5px;
                            white-space: nowrap;
                        "
                    >
                        <svg class="ico" viewBox="0 0 24 24" style="width: 13px; height: 13px">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2" />
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                        </svg>
                        Salin
                    </button>
                    <button
                        type="button"
                        class="btn btn--ghost"
                        onclick="toggleTokenVisibility()"
                        id="mask-btn"
                        style="
                            padding: 6px 12px;
                            height: 32px;
                            font-size: 12px;
                            border-radius: 8px;
                            display: inline-flex;
                            align-items: center;
                            gap: 5px;
                            white-space: nowrap;
                        "
                    >
                        <svg class="ico" id="eye-icon" viewBox="0 0 24 24" style="width: 13px; height: 13px">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                            <line x1="1" y1="1" x2="23" y2="23" />
                        </svg>
                        Mask
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push ('scripts')
<script>
                function copyToClipboard(elementId) {
                    const input = document.getElementById(elementId);
                    if (!input) return;
                    const val = input._originalValue || input.value;
                    navigator.clipboard.writeText(val).then(() => {
                        const toast = document.createElement('div');
                        toast.style.cssText =
                            'position:fixed;bottom:24px;right:24px;background:var(--primary);color:#fff;padding:10px 20px;border-radius:10px;font-size:13px;font-weight:600;box-shadow:0 8px 24px rgba(0,0,0,0.18);z-index:9999;display:flex;align-items:center;gap:8px;';
                        toast.innerHTML =
                            '<svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:#fff;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;"><polyline points="20 6 9 17 4 12"/></svg> Access Token tersalin!';
                        document.body.appendChild(toast);
                        setTimeout(() => {
                            toast.style.transition = 'opacity 0.3s';
                            toast.style.opacity = '0';
                            setTimeout(() => toast.remove(), 300);
                        }, 2200);
                    });
                }

                let tokenMasked = false;
                function toggleTokenVisibility() {
                    const ta = document.getElementById('access_token');
                    const btn = document.getElementById('mask-btn');
                    if (!ta) return;
                    if (!ta._originalValue) ta._originalValue = ta.value;
                    tokenMasked = !tokenMasked;
                    ta.value = tokenMasked ? '•'.repeat(90) : ta._originalValue;
                    btn.innerHTML = tokenMasked
                        ? '<svg class="ico" viewBox="0 0 24 24" style="width:13px;height:13px;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> Tampilkan'
                        : '<svg class="ico" id="eye-icon" viewBox="0 0 24 24" style="width:13px;height:13px;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg> Mask';
                }

                function toggleTokenVisibility() {
                    .token-stats-grid {
                        grid-template-columns: repeat(2, 1fr) !important;
                    }
                }
                @media (max-width: 560px) {
                    .token-stats-grid {
                        grid-template-columns: 1fr !important;
                    }
                }
            </style>
        @endpush
    @endsection

