@extends('layouts.app')

@section('content')
@php
    $pageId       = 'enc-rawatinap';
    $title        = 'Rawat Inap';
    $subtitle     = 'Daftar encounter pasien rawat inap (bangsal & ruangan) terintegrasi platform Satu Sehat Kemenkes';
    $iconColor    = '#5856d6';
    $iconBg       = 'rgba(88,86,214,0.12)';
    $badgeLabel   = 'Rawat Inap';
    $routeCurrent = 'encounter.rawat-inap';
@endphp

<header class="head" style="margin: 20px 24px 0;">
    <div class="head__lead">
        <div>
            <p class="head__eyebrow">Encounter</p>
            <h1 class="head__title">Encounter <em>— Rawat Inap</em></h1>
        </div>
    </div>
</header>

<section
    class="card"
    id="{{ $pageId }}"
    style="
        margin: 20px 24px 40px;
        border-radius: var(--r-card, 22px);
        border: 1px solid var(--line);
        background: var(--surface);
        box-shadow: var(--shadow);
        overflow: hidden;
        padding: 20px 24px;
    "
>
    {{-- ── Header ──────────────────────────────────────── --}}
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
                    width: 38px; height: 38px; border-radius: 12px;
                    background: {{ $iconBg }}; color: {{ $iconColor }};
                    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
                "
            >
                <svg class="ico" viewBox="0 0 24 24" style="width:20px;height:20px;stroke:{{ $iconColor }};fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/><line x1="12" y1="15" x2="12" y2="17"/></svg>
            </div>
            <div>
                <h2
                    class="card__title"
                    style="font-size:16px;font-weight:700;color:var(--text);margin:0;display:flex;align-items:center;gap:8px;"
                >
                    Encounter — {{ $title }}
                    <span class="badge" style="background:{{ $iconBg }};color:{{ $iconColor }};font-size:11px;font-weight:600;padding:2px 8px;border-radius:999px;">
                        {{ $badgeLabel }}
                    </span>
                </h2>
                <p style="font-size:12.5px;color:var(--muted);margin:2px 0 0;">{{ $subtitle }}</p>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:8px;">
            <a href="{{ route('setting.api-key.index') }}" class="btn btn--ghost"
                style="font-size:12.5px;padding:0 14px;height:36px;border-radius:10px;display:inline-flex;align-items:center;gap:6px;">
                <svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;"><path d="m21 2-2 2m-1.5 1.5 1.5 1.5-2 2-1.5-1.5M15.5 7.5 14 9l2 2 1.5-1.5M10.5 13.5a5 5 0 1 1-7-7 5 5 0 0 1 7 7Z"/></svg>
                <span>Konfigurasi API</span>
            </a>
            <button type="button" class="btn btn--primary" onclick="syncAllVisibleEncounter(this)"
                style="font-size:12.5px;padding:0 16px;height:36px;border-radius:10px;display:inline-flex;align-items:center;gap:6px;">
                <svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                <span>Sinkronisasi Massal</span>
            </button>
        </div>
    </div>

    {{-- ── Metrik Strip ──────────────────────────────────── --}}
    <div
        style="
            display: flex; gap: 0; margin-bottom: 18px;
            border: 1px solid var(--line); border-radius: 14px;
            overflow: hidden; background: var(--surface-2);
        "
        class="enc-metrics-strip"
    >
        <div style="flex:1;padding:14px 18px;border-right:1px solid var(--line)">
            <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;color:var(--muted);letter-spacing:.5px;margin-bottom:6px;">Total Pasien Ranap</div>
            <div style="font-size:22px;font-weight:800;color:var(--text);display:flex;align-items:baseline;gap:5px;">
                <span class="tnum">{{ number_format($summary['total_encounter']) }}</span>
                <small style="font-size:11px;font-weight:600;color:#1e7e34;">Kunjungan</small>
            </div>
        </div>
        <div style="flex:1;padding:14px 18px;border-right:1px solid var(--line)">
            <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;color:var(--muted);letter-spacing:.5px;margin-bottom:6px;">Terkirim Satu Sehat</div>
            <div style="font-size:22px;font-weight:800;color:var(--text);display:flex;align-items:baseline;gap:5px;">
                <span class="tnum">{{ number_format($summary['berhasil']) }}</span>
                <small style="font-size:11px;font-weight:600;color:#1e7e34;">Sukses</small>
            </div>
        </div>
        <div style="flex:1;padding:14px 18px;border-right:1px solid var(--line)">
            <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;color:var(--muted);letter-spacing:.5px;margin-bottom:6px;">Pending / Belum Sinkron</div>
            <div style="font-size:22px;font-weight:800;color:var(--text);display:flex;align-items:baseline;gap:5px;">
                <span class="tnum">{{ number_format($summary['pending']) }}</span>
                <small style="font-size:11px;font-weight:500;color:var(--muted);">Pasien</small>
            </div>
        </div>
        <div style="flex:1;padding:14px 18px;">
            <div style="font-size:10.5px;font-weight:700;text-transform:uppercase;color:var(--muted);letter-spacing:.5px;margin-bottom:6px;">Sinkronisasi Terakhir</div>
            <div style="font-size:15px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:7px;margin-top:3px;">
                <span style="width:8px;height:8px;border-radius:50%;background:#34c759;box-shadow:0 0 0 3px rgba(52,199,89,.2);flex-shrink:0;"></span>
                {{ $summary['last_sync'] }}
            </div>
        </div>
    </div>

    {{-- ── Filter Form ──────────────────────────────────── --}}
    <form method="GET" action="{{ route($routeCurrent) }}"
        style="
            background: var(--surface-2);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 18px;
            display: grid;
            grid-template-columns: 1.2fr 1.6fr 1.2fr 1.6fr auto;
            gap: 12px 14px;
            align-items: end;
        "
        class="enc-filter-form"
    >
        <div>
            <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:5px;">Tgl Masuk / Rawat</label>
            <input type="date" name="tgl_periksa" value="{{ $filter['tgl_periksa'] }}"
                style="width:100%;box-sizing:border-box;height:38px;border-radius:8px;border:1px solid var(--line);background:var(--surface);color:var(--text);font-size:13px;padding:0 10px;outline:none;" />
        </div>
        <div>
            <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:5px;">Ruang / Bangsal Rawat Inap</label>
            <select name="tempat_layanan"
                style="width:100%;box-sizing:border-box;height:38px;border-radius:8px;border:1px solid var(--line);background:var(--surface);color:var(--text);font-size:13px;padding:0 10px;outline:none;">
                <option value="all">Semua Ruangan / Bangsal</option>
                @foreach($tempat_options as $opt)
                    <option value="{{ $opt->id }}" {{ (string)$filter['tempat_layanan'] === (string)$opt->id ? 'selected' : '' }}>
                        {{ $opt->nama }} {{ $opt->satu_sehat_id ? '(SSID OK)' : '' }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:5px;">Status</label>
            <select name="status"
                style="width:100%;box-sizing:border-box;height:38px;border-radius:8px;border:1px solid var(--line);background:var(--surface);color:var(--text);font-size:13px;padding:0 10px;outline:none;">
                @foreach($status_options as $val => $label)
                    <option value="{{ $val }}" {{ $filter['status'] === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label style="font-size:12px;font-weight:600;color:var(--muted);display:block;margin-bottom:5px;">Cari Pasien (No RM / NIK / Nama)</label>
            <input type="text" name="no_rm" value="{{ $filter['no_rm'] }}" placeholder="Ketik No RM, NIK, atau Nama..."
                style="width:100%;box-sizing:border-box;height:38px;border-radius:8px;border:1px solid var(--line);background:var(--surface);color:var(--text);font-size:13px;padding:0 10px;outline:none;" />
        </div>
        <div style="display:flex; gap:8px;">
            <button type="submit" class="btn btn--primary" style="height:38px;font-size:13px;border-radius:8px;display:inline-flex;align-items:center;gap:6px;padding:0 18px;">
                <svg class="ico" viewBox="0 0 24 24" style="width:13px;height:13px;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <span>Cari</span>
            </button>
            @if(!empty($filter['no_rm']) || ($filter['tempat_layanan'] !== 'all') || ($filter['status'] !== 'all') || ($filter['tgl_periksa'] !== now()->format('Y-m-d')))
                <a href="{{ route($routeCurrent) }}" class="btn btn--ghost" style="height:38px;font-size:13px;border-radius:8px;display:inline-flex;align-items:center;gap:6px;">
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- ── Meta bar ─────────────────────────────────────── --}}
    <div class="pt-meta"
        style="min-height:40px;color:var(--muted);justify-content:space-between;align-items:center;gap:10px;padding:4px 6px 8px;font-size:12.5px;display:flex;">
        <span>Daftar Pasien · Menampilkan <b>{{ $patients->count() }}</b> dari <b>{{ $patients->total() }}</b> kunjungan rawat inap</span>
        <button type="button" class="btn btn--xs btn--ghost" onclick="toggleSelectAll(this)"
            style="display:inline-flex;align-items:center;gap:6px;">
            <svg class="ico" viewBox="0 0 24 24" style="width:14px;height:14px;"><path d="m5 12.5 4.5 4.5L19 7.5"/></svg>
            <span>Pilih semua baris</span>
        </button>
    </div>

    {{-- ── Tabel Encounter ─────────────────────────────── --}}
    <div class="table-wrap pt-wrap" style="overflow-x:auto; border: 1px solid var(--line); border-radius: 14px; background: var(--surface);">
        <table class="table pt-table" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid var(--line); background: var(--surface-2);">
                    <th scope="col" class="c-ck" style="width:44px;padding:12px 10px 12px 16px;">
                        <input type="checkbox" class="check" id="enc-check-all" onchange="selectAllRows(this)" aria-label="Pilih semua" />
                    </th>
                    <th scope="col" style="padding:12px 10px;font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;width:48px;">NO</th>
                    <th scope="col" style="padding:12px 12px;font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;min-width:110px;">TGL & Jam</th>
                    <th scope="col" style="padding:12px 14px;font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;min-width:260px;">Pasien</th>
                    <th scope="col" style="padding:12px 14px;font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;min-width:220px;">Dokter DPJP</th>
                    <th scope="col" style="padding:12px 14px;font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;min-width:180px;">Ruang Rawat</th>
                    <th scope="col" style="padding:12px 16px;font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;text-align:right;width:170px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $index => $p)
                    <tr style="cursor:pointer; border-bottom: 1px solid var(--line); transition: background 0.15s ease;" onclick="toggleRowSelect(this, event)">
                        <td class="c-ck" style="width:44px;padding:12px 10px 12px 16px;">
                            <input type="checkbox" class="check enc-row-check" value="{{ $p->pelayanan_id }}" onclick="event.stopPropagation()" />
                        </td>
                        <td style="padding:12px 10px;font-size:13px;color:var(--muted);font-weight:550;">
                            {{ $loop->iteration + ($patients->currentPage() - 1) * $patients->perPage() }}
                        </td>
                        <td style="padding:12px 12px;">
                            <div style="font-family:monospace;font-size:12px;font-weight:600;color:var(--text);white-space:nowrap;">
                                {{ \Carbon\Carbon::parse($p->tgl_act ?? $p->tgl)->format('d-m-Y') }}
                            </div>
                            <small style="color:var(--muted);font-size:11px;font-family:monospace;">
                                {{ \Carbon\Carbon::parse($p->tgl_act ?? $p->tgl)->format('H:i:s') }}
                            </small>
                        </td>
                        <td style="padding:12px 14px;">
                            <div class="cell-person" style="align-items:flex-start;gap:10px;display:flex;">
                                <span class="av av--md"
                                    style="width:34px;height:34px;border-radius:10px;background:rgba(88,86,214,.09);color:#5856d6;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                                    {{ strtoupper(substr($p->pasien_nama, 0, 1)) }}
                                </span>
                                <div>
                                    <div style="display:flex;align-items:center;gap:6px;">
                                        <b style="font-weight:700;color:var(--text);font-size:13.5px;">{{ $p->pasien_nama }}</b>
                                        <span class="badge" style="font-size:10px;padding:1px 5px;background:var(--surface-2);border:1px solid var(--line);color:var(--muted);">{{ $p->j_kelamin }}</span>
                                    </div>
                                    <div style="font-size:12px;color:var(--text);margin-top:2px;">
                                        RM: <code style="font-size:11.5px;color:var(--primary);font-family:monospace;">{{ $p->no_rm }}</code>
                                        @if($p->nik)
                                            · NIK: <span style="font-family:monospace;color:var(--muted);font-size:11.5px;">{{ $p->nik }}</span>
                                        @endif
                                    </div>
                                    <div style="margin-top:3px;">
                                        @if($p->pasien_ihs)
                                            <span class="badge" style="background:rgba(52,199,89,0.12);color:#1e7e34;font-size:10.5px;padding:2px 6px;border-radius:4px;font-family:monospace;">
                                                IHS: {{ $p->pasien_ihs }}
                                            </span>
                                        @else
                                            <span class="badge" style="background:rgba(255,149,0,0.12);color:#c07000;font-size:10.5px;padding:2px 6px;border-radius:4px;">
                                                Belum Ada IHS
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td style="padding:12px 14px;">
                            <div style="font-size:13px;font-weight:650;color:var(--text);">{{ $p->dokter_nama ?: '-' }}</div>
                            @if($p->dokter_nik)
                                <small style="color:var(--muted);font-size:11.5px;font-family:monospace;display:block;">NIK: {{ $p->dokter_nik }}</small>
                            @endif
                            @if($p->dokter_ihs)
                                <small style="color:#1e7e34;font-size:11px;font-family:monospace;">IHS: {{ $p->dokter_ihs }}</small>
                            @else
                                <small style="color:var(--muted);font-size:11px;">Belum Ada IHS</small>
                            @endif
                        </td>
                        <td style="padding:12px 14px;">
                            <div style="font-size:12.5px;font-weight:600;color:var(--text);">{{ $p->unit_nama }}</div>
                            @if($p->ssid_unit)
                                <span class="badge" style="background:rgba(52,199,89,0.1);color:#1e7e34;font-size:10px;padding:1px 6px;border-radius:4px;margin-top:2px;">SSID OK</span>
                            @else
                                <span class="badge" style="background:rgba(255,59,48,0.1);color:#dc2626;font-size:10px;padding:1px 6px;border-radius:4px;margin-top:2px;">SSID Belum Ada</span>
                            @endif
                        </td>
                        <td style="padding:12px 16px;text-align:right;">
                            <div style="display:inline-flex; align-items:center; gap:6px;">
                                @if(!empty($p->satu_sehat_id))
                                    <span class="badge" style="background:rgba(52,199,89,0.12);color:#1e7e34;font-size:11px;font-weight:600;padding:4px 8px;border-radius:6px;display:inline-flex;align-items:center;gap:4px;">
                                        <svg viewBox="0 0 24 24" style="width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2.5;"><polyline points="20 6 9 17 4 12"/></svg>
                                        Sukses
                                    </span>
                                @else
                                    <button type="button"
                                        onclick="sendEncounterSingle({{ $p->pelayanan_id }}, 'inap', this, event)"
                                        class="btn btn--xs"
                                        style="background:#5856d6;color:#fff;border:none;font-size:11.5px;font-weight:700;padding:5px 10px;border-radius:6px;cursor:pointer;">
                                        Encounter
                                    </button>
                                @endif
                                <button type="button"
                                    onclick="openPelayananDetail({{ $p->pelayanan_id }}, event)"
                                    class="btn btn--xs btn--ghost"
                                    title="Lihat Diagnosa & Tindakan"
                                    style="padding:5px 8px;font-size:11.5px;border-radius:6px;">
                                    Detail
                                </button>
                            </div>
                            @if(!empty($p->satu_sehat_id))
                                <div style="margin-top:4px;">
                                    <code style="font-size:10px;color:var(--primary);font-family:monospace;">{{ substr($p->satu_sehat_id, 0, 13) }}...</code>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:36px 20px;color:var(--muted);">
                            <div style="font-size:14px;font-weight:600;">Tidak ada kunjungan rawat inap pada filter ini</div>
                            <div style="font-size:12px;margin-top:4px;">Silakan pilih tanggal periksa atau ruang rawat lain.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div style="padding: 14px 16px; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; background: var(--surface);">
            <div style="font-size: 12.5px; color: var(--muted);">
                Menampilkan <b>{{ $patients->firstItem() ?? 0 }}</b> - <b>{{ $patients->lastItem() ?? 0 }}</b> dari <b>{{ $patients->total() }}</b> kunjungan rawat inap
            </div>
            <div>
                {{ $patients->links('partials.pagination') }}
            </div>
        </div>
    </div>
</section>

{{-- ── Modal Detail Pelayanan (Diagnosa, Tindakan, Resep) ── --}}
<div id="modal-pelayanan-detail" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.5); backdrop-filter:blur(3px); align-items:center; justify-content:center; padding:20px;">
    <div style="background:var(--surface); border:1px solid var(--line); border-radius:18px; width:100%; max-width:850px; max-height:90vh; overflow-y:auto; box-shadow:var(--shadow); padding:24px;">
        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--line); padding-bottom:14px; margin-bottom:18px;">
            <div>
                <h3 style="margin:0; font-size:16px; font-weight:700; color:var(--text);">Rincian Pelayanan Pasien (Encounter Sub-Resources)</h3>
                <p id="modal-detail-subtitle" style="margin:3px 0 0; font-size:12px; color:var(--muted);">-</p>
            </div>
            <button type="button" onclick="closePelayananDetail()" class="btn btn--xs btn--ghost" style="padding:6px 10px; font-size:14px;">✕</button>
        </div>

        <div id="modal-detail-content">
            <div style="text-align:center; padding:30px; color:var(--muted);">Memuat data...</div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function selectAllRows(master) {
        document.querySelectorAll('.enc-row-check').forEach(ck => {
            ck.checked = master.checked;
            const tr = ck.closest('tr');
            if (tr) { master.checked ? tr.classList.add('is-sel') : tr.classList.remove('is-sel'); }
        });
    }
    function toggleSelectAll(btn) {
        const master = document.getElementById('enc-check-all');
        if (master) { master.checked = !master.checked; selectAllRows(master); }
    }
    function toggleRowSelect(tr, e) {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'BUTTON' || e.target.closest('button') || e.target.closest('a')) return;
        const ck = tr.querySelector('.enc-row-check');
        if (ck) { ck.checked = !ck.checked; ck.checked ? tr.classList.add('is-sel') : tr.classList.remove('is-sel'); }
    }

    function sendEncounterSingle(pelayananId, type, btn, e) {
        if (e) e.stopPropagation();
        const orig = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = 'Kirim...';

        fetch("{{ route('encounter.send') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ pelayanan_id: pelayananId, type: type })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                btn.parentElement.innerHTML = '<span class="badge" style="background:rgba(52,199,89,0.12);color:#1e7e34;font-size:11px;font-weight:600;padding:4px 8px;border-radius:6px;display:inline-flex;align-items:center;gap:4px;"><svg viewBox="0 0 24 24" style="width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2.5;"><polyline points="20 6 9 17 4 12"/></svg>Sukses</span>';
                alert('Encounter berhasil disinkronkan: ' + res.satu_sehat_id);
            } else {
                btn.disabled = false;
                btn.innerHTML = orig;
                alert('Gagal: ' + (res.message || 'Terjadi kesalahan'));
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = orig;
            alert('Kesalahan koneksi saat mengirim Encounter');
        });
    }

    function syncAllVisibleEncounter(btn) {
        const checks = Array.from(document.querySelectorAll('.enc-row-check:checked'));
        if (checks.length === 0) {
            alert('Silakan pilih centang baris pasien yang ingin disinkronkan');
            return;
        }

        if (!confirm('Kirim ' + checks.length + ' encounter rawat inap terpilih ke SatuSehat?')) return;

        btn.disabled = true;
        const orig = btn.innerHTML;
        btn.innerHTML = 'Memproses (' + checks.length + ')...';

        let processed = 0;
        let success = 0;

        function runNext(idx) {
            if (idx >= checks.length) {
                btn.innerHTML = 'Selesai (' + success + '/' + checks.length + ')';
                setTimeout(() => { btn.innerHTML = orig; btn.disabled = false; window.location.reload(); }, 1500);
                return;
            }

            const id = checks[idx].value;
            fetch("{{ route('encounter.send') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ pelayanan_id: id, type: 'inap' })
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) success++;
                runNext(idx + 1);
            })
            .catch(() => runNext(idx + 1));
        }

        runNext(0);
    }

    function openPelayananDetail(pelayananId, e) {
        if (e) e.stopPropagation();
        const modal = document.getElementById('modal-pelayanan-detail');
        const content = document.getElementById('modal-detail-content');
        const subtitle = document.getElementById('modal-detail-subtitle');
        modal.style.display = 'flex';
        content.innerHTML = '<div style="text-align:center; padding:30px; color:var(--muted);">Memuat rincian pelayanan...</div>';

        fetch("{{ url('/encounter/detail') }}/" + pelayananId)
            .then(r => r.json())
            .then(res => {
                if (!res.success || !res.data) {
                    content.innerHTML = '<div style="color:#dc2626; padding:20px;">Gagal memuat rincian pelayanan</div>';
                    return;
                }

                const d = res.data;
                const pel = d.pelayanan;
                subtitle.innerText = pel.pasien_nama + ' (RM: ' + pel.no_rm + ') · Ruang: ' + pel.unit_nama + ' · DPJP: ' + (pel.dokter_nama || '-');

                let html = '';

                // Diagnosa (ICD-10)
                html += '<div style="margin-bottom:20px;">';
                html += '<h4 style="font-size:13.5px; font-weight:700; color:var(--text); margin:0 0 10px;">1. Rincian Diagnosa (ICD-10)</h4>';
                if (d.diagnosa && d.diagnosa.length > 0) {
                    html += '<table style="width:100%; border-collapse:collapse; font-size:12.5px; border:1px solid var(--line); border-radius:8px; overflow:hidden;">';
                    html += '<tr style="background:var(--surface-2); border-bottom:1px solid var(--line); font-weight:700; color:var(--muted);">';
                    html += '<th style="padding:8px 10px; text-align:left;">Kode ICD-10</th><th style="padding:8px 10px; text-align:left;">Nama Diagnosa</th><th style="padding:8px 10px; text-align:left;">Status SatuSehat</th><th style="padding:8px 10px; text-align:right;">Aksi</th></tr>';
                    d.diagnosa.forEach(dg => {
                        html += '<tr style="border-bottom:1px solid var(--line);">';
                        html += '<td style="padding:8px 10px; font-weight:600;"><span class="badge" style="background:var(--surface-2); border:1px solid var(--line);">' + dg.kode_icd10 + '</span></td>';
                        html += '<td style="padding:8px 10px;">' + dg.nama_diagnosa + '</td>';
                        html += '<td style="padding:8px 10px;">' + (dg.ssid_diagnosa ? '<span style="color:#1e7e34; font-weight:600;">✓ ' + dg.ssid_diagnosa.substring(0, 13) + '...</span>' : '<span style="color:var(--muted);">Belum Kirim</span>') + '</td>';
                        html += '<td style="padding:8px 10px; text-align:right;">';
                        if (!dg.ssid_diagnosa) {
                            html += '<button type="button" class="btn btn--xs btn--primary" onclick="sendConditionSingle(' + dg.id + ', this)">Kirim Diagnosa</button>';
                        } else {
                            html += '<span style="color:#1e7e34; font-size:11px;">Tersinkron</span>';
                        }
                        html += '</td></tr>';
                    });
                    html += '</table>';
                } else {
                    html += '<div style="font-size:12px; color:var(--muted); font-style:italic;">Tidak ada data diagnosa untuk kunjungan ini.</div>';
                }
                html += '</div>';

                // Tindakan (ICD-9)
                html += '<div style="margin-bottom:20px;">';
                html += '<h4 style="font-size:13.5px; font-weight:700; color:var(--text); margin:0 0 10px;">2. Rincian Tindakan (ICD-9)</h4>';
                if (d.tindakan && d.tindakan.length > 0) {
                    html += '<table style="width:100%; border-collapse:collapse; font-size:12.5px; border:1px solid var(--line); border-radius:8px; overflow:hidden;">';
                    html += '<tr style="background:var(--surface-2); border-bottom:1px solid var(--line); font-weight:700; color:var(--muted);">';
                    html += '<th style="padding:8px 10px; text-align:left;">Kode ICD-9</th><th style="padding:8px 10px; text-align:left;">Nama Tindakan</th><th style="padding:8px 10px; text-align:left;">Status SatuSehat</th></tr>';
                    d.tindakan.forEach(td => {
                        html += '<tr style="border-bottom:1px solid var(--line);">';
                        html += '<td style="padding:8px 10px; font-weight:600;"><span class="badge" style="background:var(--surface-2); border:1px solid var(--line);">' + (td.icd9 || '-') + '</span></td>';
                        html += '<td style="padding:8px 10px;">' + (td.nama_tindakan || td.uraian || '-') + '</td>';
                        html += '<td style="padding:8px 10px;">' + (td.ssid_tindakan ? '<span style="color:#1e7e34; font-weight:600;">✓ ' + td.ssid_tindakan.substring(0, 13) + '...</span>' : '<span style="color:var(--muted);">Belum Kirim</span>') + '</td>';
                        html += '</tr>';
                    });
                    html += '</table>';
                } else {
                    html += '<div style="font-size:12px; color:var(--muted); font-style:italic;">Tidak ada data tindakan untuk kunjungan ini.</div>';
                }
                html += '</div>';

                // Resep Obat
                html += '<div>';
                html += '<h4 style="font-size:13.5px; font-weight:700; color:var(--text); margin:0 0 10px;">3. Rincian Resep Obat</h4>';
                if (d.resep && d.resep.length > 0) {
                    html += '<table style="width:100%; border-collapse:collapse; font-size:12.5px; border:1px solid var(--line); border-radius:8px; overflow:hidden;">';
                    html += '<tr style="background:var(--surface-2); border-bottom:1px solid var(--line); font-weight:700; color:var(--muted);">';
                    html += '<th style="padding:8px 10px; text-align:left;">No Resep</th><th style="padding:8px 10px; text-align:left;">Qty</th><th style="padding:8px 10px; text-align:left;">Status SatuSehat</th></tr>';
                    d.resep.forEach(rs => {
                        html += '<tr style="border-bottom:1px solid var(--line);">';
                        html += '<td style="padding:8px 10px; font-weight:600;">' + rs.no_resep + '</td>';
                        html += '<td style="padding:8px 10px;">' + rs.qty + '</td>';
                        html += '<td style="padding:8px 10px;">' + (rs.ssid_detail_resep ? '<span style="color:#1e7e34; font-weight:600;">✓ Tersinkron</span>' : '<span style="color:var(--muted);">Belum Kirim</span>') + '</td>';
                        html += '</tr>';
                    });
                    html += '</table>';
                } else {
                    html += '<div style="font-size:12px; color:var(--muted); font-style:italic;">Tidak ada data resep obat untuk kunjungan ini.</div>';
                }
                html += '</div>';

                content.innerHTML = html;
            })
            .catch(() => {
                content.innerHTML = '<div style="color:#dc2626; padding:20px;">Terjadi kesalahan saat memuat rincian pelayanan.</div>';
            });
    }

    function sendConditionSingle(diagnosaId, btn) {
        btn.disabled = true;
        btn.innerHTML = 'Kirim...';
        fetch("{{ route('encounter.condition.send') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ diagnosa_id: diagnosaId })
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                btn.parentElement.innerHTML = '<span style="color:#1e7e34; font-weight:600;">✓ Sukses</span>';
                alert('Diagnosa berhasil dikirim ke SatuSehat: ' + res.satu_sehat_id);
            } else {
                btn.disabled = false;
                btn.innerHTML = 'Kirim Diagnosa';
                alert('Gagal: ' + (res.message || 'Terjadi kesalahan'));
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = 'Kirim Diagnosa';
            alert('Kesalahan jaringan');
        });
    }

    function closePelayananDetail() {
        document.getElementById('modal-pelayanan-detail').style.display = 'none';
    }
</script>
<style>
    .table tbody tr.is-sel { background: color-mix(in srgb, var(--primary) 7%, transparent) !important; }
    .table tbody tr.is-sel:hover { background: color-mix(in srgb, var(--primary) 10%, transparent) !important; }
    @media (max-width: 900px) {
        .enc-metrics-strip { flex-direction: column !important; }
        .enc-metrics-strip > div { border-right: none !important; border-bottom: 1px solid var(--line); }
        .enc-filter-form { grid-template-columns: 1fr 1fr !important; }
    }
    @media (max-width: 560px) {
        .enc-filter-form { grid-template-columns: 1fr !important; }
    }
</style>
@endpush
@endsection
