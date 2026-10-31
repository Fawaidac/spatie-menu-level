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

        {{-- ── Stats Cards Grid ───────────────────────────────────── --}}
        <div
            style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px"
            class="org-stats-grid"
        >
            {{-- Status Faskes --}}
            <div
                class="card"
                style="
                    padding: 18px 20px;
                    background: var(--surface);
                    border: 1px solid var(--line);
                    border-radius: 16px;
                    box-shadow: var(--shadow-sm);
                "
            >
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px">
                    <div
                        style="
                            width: 32px;
                            height: 32px;
                            border-radius: 10px;
                            background: rgba(52, 199, 89, 0.12);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            flex-shrink: 0;
                        "
                    >
                        <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;stroke:#1e7e34;"><polyline points="20 6 9 17 4 12" /></svg>
                    </div>
                    <span
                        style="
                            font-size: 11.5px;
                            font-weight: 700;
                            text-transform: uppercase;
                            color: var(--muted);
                            letter-spacing: 0.4px;
                        "
                        >Status Organisasi</span
                    >
                </div>
                <div
                    style="
                        font-size: 20px;
                        font-weight: 800;
                        color: #1e7e34;
                        display: flex;
                        align-items: center;
                        gap: 8px;
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
                    Aktif
                </div>
                <div style="font-size: 11.5px; color: var(--muted); margin-top: 5px">Terdaftar di Kemkes DTO</div>
            </div>

            {{-- Organization ID --}}
            <div
                class="card"
                style="
                    padding: 18px 20px;
                    background: var(--surface);
                    border: 1px solid var(--line);
                    border-radius: 16px;
                    box-shadow: var(--shadow-sm);
                "
            >
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px">
                    <div
                        style="
                            width: 32px;
                            height: 32px;
                            border-radius: 10px;
                            background: color-mix(in srgb, var(--primary) 12%, transparent);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            flex-shrink: 0;
                        "
                    >
                        <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;stroke:var(--primary);">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                    </div>
                    <span
                        style="
                            font-size: 11.5px;
                            font-weight: 700;
                            text-transform: uppercase;
                            color: var(--muted);
                            letter-spacing: 0.4px;
                        "
                        >SatuSehat Org ID</span
                    >
                </div>
                <div
                    style="
                        font-size: 19px;
                        font-weight: 800;
                        color: var(--text);
                        font-family: monospace;
                        letter-spacing: -0.5px;
                    "
                >
                    {{ $organization['id'] }}
                </div>
                <div style="font-size: 11.5px; color: var(--muted); margin-top: 5px">ID Resmi Faskes Induk</div>
            </div>

            {{-- Tipe Faskes --}}
            <div
                class="card"
                style="
                    padding: 18px 20px;
                    background: var(--surface);
                    border: 1px solid var(--line);
                    border-radius: 16px;
                    box-shadow: var(--shadow-sm);
                "
            >
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px">
                    <div
                        style="
                            width: 32px;
                            height: 32px;
                            border-radius: 10px;
                            background: rgba(88, 86, 214, 0.12);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            flex-shrink: 0;
                        "
                    >
                        <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;stroke:#5856d6;">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                    </div>
                    <span
                        style="
                            font-size: 11.5px;
                            font-weight: 700;
                            text-transform: uppercase;
                            color: var(--muted);
                            letter-spacing: 0.4px;
                        "
                        >Klasifikasi</span
                    >
                </div>
                <div style="font-size: 19px; font-weight: 800; color: var(--text)">RS Kelas B</div>
                <div style="font-size: 11.5px; color: var(--muted); margin-top: 5px">Healthcare Provider (prov)</div>
            </div>

            {{-- Wilayah Administratif --}}
            <div
                class="card"
                style="
                    padding: 18px 20px;
                    background: var(--surface);
                    border: 1px solid var(--line);
                    border-radius: 16px;
                    box-shadow: var(--shadow-sm);
                "
            >
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px">
                    <div
                        style="
                            width: 32px;
                            height: 32px;
                            border-radius: 10px;
                            background: rgba(255, 149, 0, 0.12);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            flex-shrink: 0;
                        "
                    >
                        <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;stroke:#d97706;">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <span
                        style="
                            font-size: 11.5px;
                            font-weight: 700;
                            text-transform: uppercase;
                            color: var(--muted);
                            letter-spacing: 0.4px;
                        "
                        >Kode Wilayah Kemkes</span
                    >
                </div>
                <div style="font-size: 19px; font-weight: 800; color: var(--text); font-family: monospace">
                    {{ $organization['address']['village_code'] }}
                </div>
                <div style="font-size: 11.5px; color: var(--muted); margin-top: 5px">
                    {{ $organization['address']['city'] }} · Patrang
                </div>
            </div>
        </div>

        {{-- ── Card Profil Rumah Sakit Utama ────────────────────────── --}}
        <div
            class="card"
            style="
                background: var(--surface);
                border: 1px solid var(--line);
                border-radius: 18px;
                box-shadow: var(--shadow-sm);
                overflow: hidden;
                margin-bottom: 24px;
            "
        >
            <div
                style="
                    padding: 20px 24px;
                    border-bottom: 1px solid var(--line);
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    flex-wrap: wrap;
                "
            >
                <span
                    style="
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 36px;
                        height: 36px;
                        border-radius: 10px;
                        background: var(--primary);
                        color: #fff;
                        flex-shrink: 0;
                    "
                >
                    <svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;stroke:#fff;">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                </span>
                <div>
                    <h2 style="font-size: 16px; font-weight: 700; margin: 0; color: var(--text)">
                        Profil Rumah Sakit Terdaftar
                    </h2>
                    <p style="
                            font-size: 12.5px;
                            color: var(--muted);
                            margin: 2px 0 0;
                        ">Master Data Entitas Faskes pada Platform Satu Sehat Kemenkes</p>
                </div>
                <div style="margin-left: auto; display: flex; align-items: center; gap: 8px">
                    <span
                        class="badge"
                        style="
                            background: rgba(52, 199, 89, 0.12);
                            color: #1e7e34;
                            font-size: 11.5px;
                            font-weight: 600;
                            padding: 4px 12px;
                            border-radius: 999px;
                        "
                    >
                        ✓ FHIR R4 Organization Verified
                    </span>
                </div>
            </div>

            <div style="padding: 24px">
                <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 24px" class="org-details-grid">
                    {{-- Kolom Kiri: Info Lembaga & Identitas --}}
                    <div>
                        <h3
                            style="
                                font-size: 13px;
                                font-weight: 700;
                                text-transform: uppercase;
                                color: var(--muted);
                                letter-spacing: 0.5px;
                                margin-bottom: 16px;
                                display: flex;
                                align-items: center;
                                gap: 6px;
                            "
                        >
                            <svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;stroke:var(--primary);">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="16" x2="12" y2="12" />
                                <line x1="12" y1="8" x2="12.01" y2="8" />
                            </svg>
                            Identitas Resmi Faskes
                        </h3>

                        <div style="display: flex; flex-direction: column; gap: 14px">
                            <div
                                style="
                                    background: var(--surface-2);
                                    padding: 14px 16px;
                                    border-radius: 12px;
                                    border: 1px solid var(--line);
                                "
                            >
                                <div
                                    style="
                                        font-size: 11px;
                                        font-weight: 600;
                                        color: var(--muted);
                                        text-transform: uppercase;
                                        margin-bottom: 4px;
                                    "
                                >
                                    Nama Resmi Fasilitas Kesehatan
                                </div>
                                <div style="font-size: 16px; font-weight: 800; color: var(--text)">
                                    {{ $organization['name'] }}
                                </div>
                                <div style="font-size: 12px; color: var(--muted); margin-top: 2px">
                                    {{ $organization['legal_name'] }}
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px">
                                <div
                                    style="
                                        background: var(--surface-2);
                                        padding: 12px 14px;
                                        border-radius: 12px;
                                        border: 1px solid var(--line);
                                    "
                                >
                                    <div
                                        style="
                                            font-size: 11px;
                                            font-weight: 600;
                                            color: var(--muted);
                                            text-transform: uppercase;
                                            margin-bottom: 4px;
                                        "
                                    >
                                        Tipe Resource FHIR
                                    </div>
                                    <div style="font-size: 13px; font-weight: 700; color: var(--text)">
                                        <code>{{ $organization['type_code'] }}</code>
                                        <span style="font-size: 11.5px; font-weight: 500; color: var(--muted)"
                                            >({{ $organization['type_display'] }})</span
                                        >
                                    </div>
                                </div>
                                <div
                                    style="
                                        background: var(--surface-2);
                                        padding: 12px 14px;
                                        border-radius: 12px;
                                        border: 1px solid var(--line);
                                    "
                                >
                                    <div
                                        style="
                                            font-size: 11px;
                                            font-weight: 600;
                                            color: var(--muted);
                                            text-transform: uppercase;
                                            margin-bottom: 4px;
                                        "
                                    >
                                        Kelas Rumah Sakit
                                    </div>
                                    <div style="font-size: 13px; font-weight: 700; color: var(--text)">
                                        Kelas B Pendidikan
                                    </div>
                                </div>
                            </div>

                            <div
                                style="
                                    background: var(--surface-2);
                                    padding: 12px 14px;
                                    border-radius: 12px;
                                    border: 1px solid var(--line);
                                "
                            >
                                <div
                                    style="
                                        font-size: 11px;
                                        font-weight: 600;
                                        color: var(--muted);
                                        text-transform: uppercase;
                                        margin-bottom: 4px;
                                    "
                                >
                                    Organisasi Induk (partOf)
                                </div>
                                <div
                                    style="
                                        font-size: 13.5px;
                                        font-weight: 700;
                                        color: var(--text);
                                        display: flex;
                                        align-items: center;
                                        justify-content: space-between;
                                    "
                                >
                                    <span>{{ $organization['part_of'] }}</span>
                                    <code
                                        style="font-size: 11px; color: var(--muted)"
                                        >{{ $organization['part_of_ref'] }}</code
                                    >
                                </div>
                            </div>

                            <div>
                                <div
                                    style="
                                        font-size: 11px;
                                        font-weight: 600;
                                        color: var(--muted);
                                        text-transform: uppercase;
                                        margin-bottom: 8px;
                                    "
                                >
                                    Alias / Nama Dikenal (Aliases)
                                </div>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap">
                                    @foreach ($organization['alias'] as $alias)
                                        <span
                                            class="badge"
                                            style="
                                                background: var(--surface-2);
                                                border: 1px solid var(--line);
                                                color: var(--text);
                                                font-size: 12px;
                                                padding: 4px 10px;
                                                border-radius: 8px;
                                            "
                                        >
                                            {{ $alias }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Kontak & Admin Entitas --}}
                    <div>
                        <h3
                            style="
                                font-size: 13px;
                                font-weight: 700;
                                text-transform: uppercase;
                                color: var(--muted);
                                letter-spacing: 0.5px;
                                margin-bottom: 16px;
                                display: flex;
                                align-items: center;
                                gap: 6px;
                            "
                        >
                            <svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;stroke:var(--primary);"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" /></svg>
                            Kontak & Entitas Administrasi
                        </h3>

                        <div style="display: flex; flex-direction: column; gap: 14px">
                            {{-- Telepon & Email Faskes --}}
                            <div
                                style="
                                    background: var(--surface-2);
                                    padding: 14px 16px;
                                    border-radius: 12px;
                                    border: 1px solid var(--line);
                                "
                            >
                                <div
                                    style="
                                        display: flex;
                                        align-items: center;
                                        justify-content: space-between;
                                        margin-bottom: 10px;
                                    "
                                >
                                    <span
                                        style="
                                            font-size: 11px;
                                            font-weight: 600;
                                            color: var(--muted);
                                            text-transform: uppercase;
                                        "
                                        >Saluran Kontak Resmi</span
                                    >
                                    <span
                                        class="badge"
                                        style="
                                            background: rgba(52, 199, 89, 0.1);
                                            color: #1e7e34;
                                            font-size: 10.5px;
                                            padding: 2px 6px;
                                            border-radius: 4px;
                                        "
                                        >work</span
                                    >
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 8px">
                                    <div
                                        style="
                                            display: flex;
                                            align-items: center;
                                            gap: 8px;
                                            font-size: 13.5px;
                                            color: var(--text);
                                        "
                                    >
                                        <svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;stroke:var(--muted);flex-shrink:0;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" /></svg>
                                        <span
                                            style="font-weight: 600"
                                            >{{ $organization['telecom']['phone_display'] }}</span
                                        >
                                        <span style="font-size: 12px; color: var(--muted)"
                                            >({{ $organization['telecom']['phone'] }})</span
                                        >
                                    </div>
                                    <div
                                        style="
                                            display: flex;
                                            align-items: center;
                                            gap: 8px;
                                            font-size: 13.5px;
                                            color: var(--text);
                                        "
                                    >
                                        <svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;stroke:var(--muted);flex-shrink:0;">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                            <polyline points="22,6 12,13 2,6" />
                                        </svg>
                                        <span>{{ $organization['telecom']['email'] }}</span>
                                    </div>
                                    <div
                                        style="
                                            display: flex;
                                            align-items: center;
                                            gap: 8px;
                                            font-size: 13.5px;
                                            color: var(--primary);
                                        "
                                    >
                                        <svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;stroke:var(--primary);flex-shrink:0;">
                                            <circle cx="12" cy="12" r="10" />
                                            <line x1="2" y1="12" x2="22" y2="12" />
                                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                                        </svg>
                                        <a
                                            href="{{ $organization['telecom']['website'] }}"
                                            target="_blank"
                                            style="color: var(--primary); text-decoration: none; font-weight: 550"
                                            >{{ $organization['telecom']['website'] }}</a
                                        >
                                    </div>
                                </div>
                            </div>

                            {{-- Kontak Entitas Administrasi (contact entity) --}}
                            <div
                                style="
                                    background: var(--surface-2);
                                    padding: 14px 16px;
                                    border-radius: 12px;
                                    border: 1px solid var(--line);
                                "
                            >
                                <div
                                    style="
                                        display: flex;
                                        align-items: center;
                                        justify-content: space-between;
                                        margin-bottom: 8px;
                                    "
                                >
                                    <span
                                        style="
                                            font-size: 11px;
                                            font-weight: 600;
                                            color: var(--muted);
                                            text-transform: uppercase;
                                        "
                                        >Penanggung Jawab Integrasi Satu Sehat</span
                                    >
                                    <span
                                        class="badge"
                                        style="
                                            background: rgba(88, 86, 214, 0.12);
                                            color: #5856d6;
                                            font-size: 10.5px;
                                            font-weight: 700;
                                            padding: 2px 6px;
                                            border-radius: 4px;
                                        "
                                        >ADMIN</span
                                    >
                                </div>
                                <div style="font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 6px">
                                    {{ $organization['contact']['name'] }}
                                </div>
                                <div
                                    style="
                                        font-size: 12.5px;
                                        color: var(--muted);
                                        display: flex;
                                        flex-direction: column;
                                        gap: 4px;
                                    "
                                >
                                    <div>
                                        Email:
                                        <span
                                            style="color: var(--text); font-family: monospace"
                                            >{{ $organization['contact']['email'] }}</span
                                        >
                                    </div>
                                    <div>
                                        Telepon:
                                        <span style="color: var(--text)">{{ $organization['contact']['phone'] }}</span>
                                    </div>
                                </div>
                            </div>

                            <div
                                style="
                                    display: flex;
                                    align-items: center;
                                    justify-content: space-between;
                                    font-size: 11.5px;
                                    color: var(--muted);
                                    padding: 4px 6px;
                                "
                            >
                                <span>Terakhir disinkronkan: <strong>{{ $organization['synced_at'] }}</strong></span>
                                <span
                                    style="
                                        color: #1e7e34;
                                        font-weight: 600;
                                        display: inline-flex;
                                        align-items: center;
                                        gap: 4px;
                                    "
                                >
                                    <span
                                        style="width: 6px; height: 6px; border-radius: 50%; background: #34c759"
                                    ></span>
                                    Connected
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Card Alamat & Extension Administrasi Kemkes ──────────── --}}
        <div
            class="card"
            style="
                background: var(--surface);
                border: 1px solid var(--line);
                border-radius: 18px;
                box-shadow: var(--shadow-sm);
                overflow: hidden;
                margin-bottom: 24px;
            "
        >
            <div
                style="
                    padding: 18px 24px;
                    border-bottom: 1px solid var(--line);
                    display: flex;
                    align-items: center;
                    gap: 10px;
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
                        background: rgba(255, 149, 0, 0.14);
                        color: #d97706;
                        flex-shrink: 0;
                    "
                >
                    <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;stroke:#d97706;">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </span>
                <div>
                    <h3 style="font-size: 15px; font-weight: 700; margin: 0; color: var(--text)">
                        Alamat & Kode Wilayah Administrasi Kemenkes
                    </h3>
                    <p style="
                            font-size: 12px;
                            color: var(--muted);
                            margin: 0;
                        ">Extension <code>administrativeCode</code> resmi Satu Sehat FHIR R4</p>
                </div>
                <span
                    class="badge"
                    style="
                        margin-left: auto;
                        background: var(--surface-2);
                        border: 1px solid var(--line);
                        font-family: monospace;
                        font-size: 11.5px;
                        color: var(--text);
                    "
                >
                    use: work
                </span>
            </div>

            <div style="padding: 24px">
                <div
                    style="
                        margin-bottom: 18px;
                        background: var(--surface-2);
                        padding: 14px 18px;
                        border-radius: 12px;
                        border: 1px solid var(--line);
                    "
                >
                    <div
                        style="
                            font-size: 11px;
                            font-weight: 700;
                            text-transform: uppercase;
                            color: var(--muted);
                            letter-spacing: 0.5px;
                            margin-bottom: 4px;
                        "
                    >
                        Alamat Fisik (line)
                    </div>
                    <div style="font-size: 15px; font-weight: 700; color: var(--text)">
                        {{ $organization['address']['line'] }}
                    </div>
                    <div style="font-size: 12.5px; color: var(--muted); margin-top: 2px">
                        Kecamatan {{ $organization['address']['district'] }}, {{ $organization['address']['city'] }}, {{ $organization['address']['state'] }} {{ $organization['address']['postal_code'] }}, {{ $organization['address']['country_name'] }}
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px" class="addr-codes-grid">
                    <div
                        style="
                            padding: 14px 16px;
                            background: var(--surface-2);
                            border: 1px solid var(--line);
                            border-radius: 12px;
                        "
                    >
                        <div
                            style="
                                font-size: 11px;
                                font-weight: 600;
                                color: var(--muted);
                                text-transform: uppercase;
                                margin-bottom: 4px;
                            "
                        >
                            Provinsi (province)
                        </div>
                        <div style="font-size: 14px; font-weight: 700; color: var(--text)">
                            {{ $organization['address']['province_name'] }}
                        </div>
                        <div
                            style="
                                font-size: 12px;
                                font-family: monospace;
                                color: var(--primary);
                                font-weight: 700;
                                margin-top: 4px;
                            "
                        >
                            Kode: {{ $organization['address']['province_code'] }}
                        </div>
                    </div>

                    <div
                        style="
                            padding: 14px 16px;
                            background: var(--surface-2);
                            border: 1px solid var(--line);
                            border-radius: 12px;
                        "
                    >
                        <div
                            style="
                                font-size: 11px;
                                font-weight: 600;
                                color: var(--muted);
                                text-transform: uppercase;
                                margin-bottom: 4px;
                            "
                        >
                            Kota / Kab (city)
                        </div>
                        <div style="font-size: 14px; font-weight: 700; color: var(--text)">
                            {{ $organization['address']['city'] }}
                        </div>
                        <div
                            style="
                                font-size: 12px;
                                font-family: monospace;
                                color: var(--primary);
                                font-weight: 700;
                                margin-top: 4px;
                            "
                        >
                            Kode: {{ $organization['address']['city_code'] }}
                        </div>
                    </div>

                    <div
                        style="
                            padding: 14px 16px;
                            background: var(--surface-2);
                            border: 1px solid var(--line);
                            border-radius: 12px;
                        "
                    >
                        <div
                            style="
                                font-size: 11px;
                                font-weight: 600;
                                color: var(--muted);
                                text-transform: uppercase;
                                margin-bottom: 4px;
                            "
                        >
                            Kecamatan (district)
                        </div>
                        <div style="font-size: 14px; font-weight: 700; color: var(--text)">
                            {{ $organization['address']['district'] }}
                        </div>
                        <div
                            style="
                                font-size: 12px;
                                font-family: monospace;
                                color: var(--primary);
                                font-weight: 700;
                                margin-top: 4px;
                            "
                        >
                            Kode: {{ $organization['address']['district_code'] }}
                        </div>
                    </div>

                    <div
                        style="
                            padding: 14px 16px;
                            background: var(--surface-2);
                            border: 1px solid var(--line);
                            border-radius: 12px;
                        "
                    >
                        <div
                            style="
                                font-size: 11px;
                                font-weight: 600;
                                color: var(--muted);
                                text-transform: uppercase;
                                margin-bottom: 4px;
                            "
                        >
                            Desa / Kel (village)
                        </div>
                        <div style="font-size: 14px; font-weight: 700; color: var(--text)">
                            {{ $organization['address']['village_name'] }}
                        </div>
                        <div
                            style="
                                font-size: 12px;
                                font-family: monospace;
                                color: var(--primary);
                                font-weight: 700;
                                margin-top: 4px;
                            "
                        >
                            Kode: {{ $organization['address']['village_code'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Tabel Unit / Departemen Faskes (Child Organizations) ──── --}}
        <div
            class="card"
            style="
                background: var(--surface);
                border: 1px solid var(--line);
                border-radius: 18px;
                box-shadow: var(--shadow-sm);
                overflow: hidden;
                margin-bottom: 24px;
            "
        >
            <div
                style="
                    padding: 18px 24px;
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
                            background: rgba(88, 86, 214, 0.12);
                            color: #5856d6;
                            flex-shrink: 0;
                        "
                    >
                        <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;stroke:#5856d6;">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </span>
                    <div>
                        <h3 style="font-size: 15px; font-weight: 700; margin: 0; color: var(--text)">
                            Unit Layanan & Departemen Rumah Sakit
                        </h3>
                        <p style="
                                font-size: 12px;
                                color: var(--muted);
                                margin: 0;
                            ">Sub-Organisasi (Child Units) terdaftar dalam hirarki faskes</p>
                    </div>
                </div>
                <span
                    class="badge"
                    style="
                        background: var(--surface-2);
                        border: 1px solid var(--line);
                        font-size: 12px;
                        font-weight: 600;
                        padding: 4px 10px;
                        border-radius: 8px;
                    "
                >
                    {{ count($units) }} Unit Terdaftar
                </span>
            </div>

            <div style="overflow-x: auto">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left">
                    <thead>
                        <tr
                            style="
                                background: var(--surface-2);
                                border-bottom: 1px solid var(--line);
                                color: var(--muted);
                                font-size: 11px;
                                text-transform: uppercase;
                                letter-spacing: 0.5px;
                            "
                        >
                            <th style="padding: 12px 20px">ID Organisasi Unit</th>
                            <th style="padding: 12px 20px">Nama Unit / Poliklinik</th>
                            <th style="padding: 12px 20px">Kode FHIR</th>
                            <th style="padding: 12px 20px">Tipe Layanan</th>
                            <th style="padding: 12px 20px">Kontak</th>
                            <th style="padding: 12px 20px; text-align: right">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($units as $unit)
                            <tr
                                style="border-bottom: 1px solid var(--line); transition: background 0.15s ease"
                                onmouseover="this.style.background = 'var(--surface-2)'"
                                onmouseout="this.style.background = 'transparent'"
                            >
                                <td
                                    style="
                                        padding: 14px 20px;
                                        font-family: monospace;
                                        font-weight: 600;
                                        color: var(--primary);
                                    "
                                >
                                    {{ $unit['id'] }}
                                </td>
                                <td style="padding: 14px 20px; font-weight: 700; color: var(--text)">
                                    {{ $unit['name'] }}
                                </td>
                                <td style="padding: 14px 20px">
                                    <code
                                        style="
                                            font-size: 11.5px;
                                            background: var(--surface-2);
                                            padding: 2px 6px;
                                            border-radius: 4px;
                                            border: 1px solid var(--line-2);
                                        "
                                        >{{ $unit['code'] }}</code
                                    >
                                </td>
                                <td style="padding: 14px 20px; color: var(--muted)">{{ $unit['type'] }}</td>
                                <td style="padding: 14px 20px; color: var(--muted); font-size: 12px">
                                    {{ $unit['phone'] }}
                                </td>
                                <td style="padding: 14px 20px; text-align: right">
                                    <span
                                        class="badge"
                                        style="
                                            background: rgba(52, 199, 89, 0.12);
                                            color: #1e7e34;
                                            font-size: 11px;
                                            font-weight: 600;
                                            padding: 3px 8px;
                                            border-radius: 999px;
                                        "
                                    >
                                        {{ $unit['status'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

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
                        rows="18"
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
