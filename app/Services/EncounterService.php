<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class EncounterService
{
    protected SatusehatService $satusehatService;

    public function __construct(SatusehatService $satusehatService)
    {
        $this->satusehatService = $satusehatService;
    }

    /**
     * Dapatkan daftar unit/tempat layanan berdasarkan parent_id
     */
    public function getUnits(string $type): array
    {
        $query = DB::connection('billing')->table('b_ms_unit')
            ->select('id', 'kode', 'nama', 'keterangan', 'satu_sehat_id')
            ->where('aktif', 1);

        if ($type === 'jalan') {
            $query->where('parent_id', 1);
        } elseif ($type === 'igd') {
            $query->where(function ($q) {
                $q->where('id', 44)->orWhere('parent_id', 44);
            });
        } elseif ($type === 'inap') {
            $query->where('parent_id', 27);
        }

        return $query->orderBy('nama', 'asc')->get()->toArray();
    }

    /**
     * Query data kunjungan & pelayanan encounter
     */
    public function getEncounters(string $type, array $filter, int $perPage = 15): LengthAwarePaginator
    {
        $query = DB::connection('billing')->table('b_pelayanan as pl')
            ->join('b_kunjungan as k', 'k.id', '=', 'pl.kunjungan_id')
            ->join('b_ms_pasien as p', 'p.id', '=', 'k.pasien_id')
            ->join('b_ms_unit as u', 'u.id', '=', 'pl.unit_id')
            ->leftJoin('b_ms_pegawai as pg', 'pg.id', '=', 'pl.dokter_pj_id')
            ->leftJoin('b_ms_kso as kso', 'kso.id', '=', 'k.kso_id')
            ->select([
                'pl.id as pelayanan_id',
                'k.id as kunjungan_id',
                'p.id as pasien_id',
                'pl.tgl',
                'pl.tgl_act',
                'pl.satu_sehat_id',
                'pl.tgl_ssid',
                'pl.dilayani',
                'k.pulang',
                'k.tgl_pulang',
                'p.no_rm',
                'p.nama as pasien_nama',
                'p.sex as j_kelamin',
                'p.no_id as nik',
                'p.no_ihs as pasien_ihs',
                'p.tgl_lahir',
                'pg.nama as dokter_nama',
                'pg.nik as dokter_nik',
                'pg.no_ihs as dokter_ihs',
                'u.id as unit_id',
                'u.nama as unit_nama',
                'u.keterangan as ket_unit',
                'u.satu_sehat_id as ssid_unit',
                'kso.nama as penjamin_nama',
            ]);

        // Filter unit jenis
        if ($type === 'jalan') {
            $query->where('u.parent_id', 1);
        } elseif ($type === 'igd') {
            $query->where(function ($q) {
                $q->where('u.id', 44)->orWhere('u.parent_id', 44);
            });
        } elseif ($type === 'inap') {
            $query->where('u.parent_id', 27);
        }

        // Filter Tanggal Periksa
        if (!empty($filter['tgl_periksa'])) {
            $query->whereDate('pl.tgl', $filter['tgl_periksa']);
        }

        // Filter Tempat Layanan (Unit ID)
        if (!empty($filter['tempat_layanan']) && $filter['tempat_layanan'] !== 'all') {
            $query->where('pl.unit_id', $filter['tempat_layanan']);
        }

        // Filter Status Dilayani / Pulang
        if (isset($filter['status']) && $filter['status'] !== 'all' && $filter['status'] !== '') {
            if ($filter['status'] === 'datang' || $filter['status'] == '4') {
                $query->where('k.pulang', 0);
            } elseif ($filter['status'] === 'pulang' || $filter['status'] == '2') {
                $query->where('k.pulang', 1);
            } elseif ($filter['status'] === 'synced') {
                $query->whereNotNull('pl.satu_sehat_id')->where('pl.satu_sehat_id', '<>', '');
            } elseif ($filter['status'] === 'pending') {
                $query->where(function ($q) {
                    $q->whereNull('pl.satu_sehat_id')->orWhere('pl.satu_sehat_id', '');
                });
            }
        }

        // Filter Cari (No RM / Nama / NIK)
        if (!empty($filter['no_rm'])) {
            $cari = trim($filter['no_rm']);
            $query->where(function ($q) use ($cari) {
                $q->where('p.no_rm', 'LIKE', "%{$cari}%")
                  ->orWhere('p.nama', 'LIKE', "%{$cari}%")
                  ->orWhere('p.no_id', 'LIKE', "%{$cari}%")
                  ->orWhere('p.no_ihs', 'LIKE', "%{$cari}%");
            });
        }

        return $query->orderBy('pl.tgl_act', 'desc')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Hitung ringkasan statistik encounter
     */
    public function getSummary(string $type, array $filter): array
    {
        $query = DB::connection('billing')->table('b_pelayanan as pl')
            ->join('b_kunjungan as k', 'k.id', '=', 'pl.kunjungan_id')
            ->join('b_ms_unit as u', 'u.id', '=', 'pl.unit_id');

        if ($type === 'jalan') {
            $query->where('u.parent_id', 1);
        } elseif ($type === 'igd') {
            $query->where(function ($q) {
                $q->where('u.id', 44)->orWhere('u.parent_id', 44);
            });
        } elseif ($type === 'inap') {
            $query->where('u.parent_id', 27);
        }

        if (!empty($filter['tgl_periksa'])) {
            $query->whereDate('pl.tgl', $filter['tgl_periksa']);
        }
        if (!empty($filter['tempat_layanan']) && $filter['tempat_layanan'] !== 'all') {
            $query->where('pl.unit_id', $filter['tempat_layanan']);
        }

        $total = (clone $query)->count();
        $berhasil = (clone $query)
            ->whereNotNull('pl.satu_sehat_id')
            ->where('pl.satu_sehat_id', '<>', '')
            ->count();

        $lastSync = DB::connection('billing')->table('b_pelayanan')
            ->whereNotNull('satu_sehat_id')
            ->where('satu_sehat_id', '<>', '')
            ->orderBy('tgl_ssid', 'desc')
            ->value('tgl_ssid');

        return [
            'total_encounter' => $total,
            'berhasil'        => $berhasil,
            'pending'         => $total - $berhasil,
            'last_sync'       => $lastSync ? Carbon::parse($lastSync)->format('d M Y, H:i') : now()->format('d M Y, H:i'),
        ];
    }

    /**
     * Dapatkan detail pelayanan (Diagnosa, Tindakan, Resep Obat)
     */
    public function getPelayananDetail(int $pelayananId): array
    {
        // 1. Info Pelayanan & Pasien
        $pelayanan = DB::connection('billing')->table('b_pelayanan as pl')
            ->join('b_kunjungan as k', 'k.id', '=', 'pl.kunjungan_id')
            ->join('b_ms_pasien as p', 'p.id', '=', 'k.pasien_id')
            ->join('b_ms_unit as u', 'u.id', '=', 'pl.unit_id')
            ->leftJoin('b_ms_pegawai as pg', 'pg.id', '=', 'pl.dokter_pj_id')
            ->select([
                'pl.id as pelayanan_id', 'k.id as kunjungan_id', 'p.id as pasien_id',
                'p.nama as pasien_nama', 'p.no_rm', 'p.no_ihs as pasien_ihs',
                'pg.nama as dokter_nama', 'pg.no_ihs as dokter_ihs',
                'u.nama as unit_nama', 'u.satu_sehat_id as ssid_unit', 'u.keterangan as ket_unit',
                'pl.satu_sehat_id', 'pl.tgl', 'pl.tgl_act',
            ])
            ->where('pl.id', $pelayananId)
            ->first();

        if (!$pelayanan) {
            return [];
        }

        // 2. Diagnosa (ICD-10)
        $diagnosa = DB::connection('billing')->table('b_diagnosa as d')
            ->join('b_ms_diagnosa as md', 'md.id', '=', 'd.ms_diagnosa_id')
            ->select([
                'd.diagnosa_id as id',
                'md.kode as kode_icd10',
                'md.nama as nama_diagnosa',
                'd.satu_sehat_id as ssid_diagnosa',
                'd.tgl_ssid',
            ])
            ->where('d.pelayanan_id', $pelayananId)
            ->get();

        // 3. Tindakan (ICD-9)
        $tindakan = DB::connection('billing')->table('b_sep_penjamin_tindakan as t')
            ->leftJoin('b_ms_icd9 as icd9', 'icd9.kode', '=', 't.icd9')
            ->leftJoin('b_ms_diagnosa as md', 'md.kode', '=', 't.icd10')
            ->select([
                't.id',
                't.icd9',
                'icd9.nama as nama_tindakan',
                'icd9.snomed_code',
                'icd9.snomed_name',
                't.icd10',
                'md.nama as nama_diagnosa',
                't.satu_sehat_id as ssid_tindakan',
                't.tgl1',
                't.tgl2',
            ])
            ->where('t.pelayanan_id', $pelayananId)
            ->get();

        // 4. Resep Obat
        $resep = DB::connection('billing')->table('b_resep_obat as r')
            ->join('b_detail_resep_obat as ro', 'ro.b_resep_obat_id', '=', 'r.id')
            ->select([
                'r.id as resep_id',
                'r.no_resep',
                'r.tgl',
                'ro.obat_id',
                'ro.qty',
                'ro.satu_sehat_id as ssid_detail_resep',
            ])
            ->where('r.kunjungan_id', $pelayanan->kunjungan_id)
            ->get();

        return [
            'pelayanan' => $pelayanan,
            'diagnosa'  => $diagnosa,
            'tindakan'  => $tindakan,
            'resep'     => $resep,
        ];
    }

    /**
     * Kirim data Encounter ke SatuSehat
     */
    public function sendEncounter(int $pelayananId, string $type = 'jalan'): array
    {
        $pelayanan = DB::connection('billing')->table('b_pelayanan as pl')
            ->join('b_kunjungan as k', 'k.id', '=', 'pl.kunjungan_id')
            ->join('b_ms_pasien as p', 'p.id', '=', 'k.pasien_id')
            ->join('b_ms_unit as u', 'u.id', '=', 'pl.unit_id')
            ->leftJoin('b_ms_pegawai as pg', 'pg.id', '=', 'pl.dokter_pj_id')
            ->select([
                'pl.id as pelayanan_id', 'p.nama as pasien_nama', 'p.no_ihs as pasien_ihs',
                'pg.nama as dokter_nama', 'pg.no_ihs as dokter_ihs',
                'u.nama as unit_nama', 'u.keterangan as ket_unit', 'u.satu_sehat_id as ssid_unit',
                'pl.tgl_act', 'pl.satu_sehat_id',
            ])
            ->where('pl.id', $pelayananId)
            ->first();

        if (!$pelayanan) {
            return ['success' => false, 'message' => 'Data pelayanan tidak ditemukan'];
        }

        if (empty($pelayanan->pasien_ihs)) {
            return ['success' => false, 'message' => 'Nomor IHS Pasien belum terdaftar di SatuSehat'];
        }

        if (empty($pelayanan->dokter_ihs)) {
            return ['success' => false, 'message' => 'Nomor IHS Dokter/DPJP belum terdaftar di SatuSehat'];
        }

        if (empty($pelayanan->ssid_unit)) {
            return ['success' => false, 'message' => 'Unit/Ruang belum memiliki Satu Sehat ID (Location)'];
        }

        $orgId = $this->satusehatService->getOrganizationId();
        if (!$orgId) {
            return ['success' => false, 'message' => 'ID Organisasi belum dikonfigurasi'];
        }

        $classCode = match($type) {
            'inap' => 'IMP',
            'igd'  => 'EMER',
            default => 'AMB',
        };

        $classDisplay = match($type) {
            'inap' => 'inpatient encounter',
            'igd'  => 'emergency',
            default => 'ambulatory',
        };

        $tglAct = Carbon::parse($pelayanan->tgl_act ?? now())->format('Y-m-d\TH:i:sP');

        $payload = [
            'resourceType' => 'Encounter',
            'status'       => 'arrived',
            'class'        => [
                'system'  => 'http://terminology.hl7.org/CodeSystem/v3-ActCode',
                'code'    => $classCode,
                'display' => $classDisplay,
            ],
            'subject' => [
                'reference' => 'Patient/' . $pelayanan->pasien_ihs,
                'display'   => $pelayanan->pasien_nama,
            ],
            'participant' => [
                [
                    'type' => [
                        [
                            'coding' => [
                                [
                                    'system'  => 'http://terminology.hl7.org/CodeSystem/v3-ParticipationType',
                                    'code'    => 'ATND',
                                    'display' => 'attender',
                                ],
                            ],
                        ],
                    ],
                    'individual' => [
                        'reference' => 'Practitioner/' . $pelayanan->dokter_ihs,
                        'display'   => $pelayanan->dokter_nama,
                    ],
                ],
            ],
            'period' => [
                'start' => $tglAct,
            ],
            'location' => [
                [
                    'location' => [
                        'reference' => 'Location/' . $pelayanan->ssid_unit,
                        'display'   => $pelayanan->ket_unit ?: $pelayanan->unit_nama,
                    ],
                ],
            ],
            'statusHistory' => [
                [
                    'status' => 'arrived',
                    'period' => [
                        'start' => $tglAct,
                    ],
                ],
            ],
            'serviceProvider' => [
                'reference' => 'Organization/' . $orgId,
            ],
            'identifier' => [
                [
                    'system' => 'http://sys-ids.kemkes.go.id/encounter/' . $orgId,
                    'value'  => 'P' . $pelayananId,
                ],
            ],
        ];

        $res = $this->satusehatService->postEncounter($payload);
        $satuSehatId = $res['id'] ?? null;

        if ($satuSehatId) {
            DB::connection('billing')->table('b_pelayanan')->where('id', $pelayananId)->update([
                'satu_sehat_id' => $satuSehatId,
                'tgl_ssid'      => now(),
            ]);

            return [
                'success'       => true,
                'satu_sehat_id' => $satuSehatId,
                'message'       => 'Encounter berhasil dikirim ke SatuSehat',
            ];
        }

        $issue = $res['issue'] ?? null;
        $errMsg = 'Gagal mengirim Encounter ke SatuSehat';
        if ($issue && is_array($issue) && isset($issue[0]['diagnostics'])) {
            $errMsg .= ': ' . $issue[0]['diagnostics'];
        }

        return [
            'success' => false,
            'message' => $errMsg,
            'response' => $res,
        ];
    }

    /**
     * Kirim Diagnosa (Condition) ke SatuSehat
     */
    public function sendCondition(int $diagnosaId): array
    {
        $d = DB::connection('billing')->table('b_diagnosa as d')
            ->join('b_pelayanan as pl', 'pl.id', '=', 'd.pelayanan_id')
            ->join('b_ms_pasien as p', 'p.id', '=', 'pl.pasien_id')
            ->join('b_ms_diagnosa as md', 'md.id', '=', 'd.ms_diagnosa_id')
            ->select([
                'd.diagnosa_id', 'd.satu_sehat_id', 'pl.satu_sehat_id as ssid_pelayanan',
                'p.nama as pasien_nama', 'p.no_ihs as pasien_ihs',
                'md.kode as icd10', 'md.nama as diagnosa_nama',
                'pl.tgl',
            ])
            ->where('d.diagnosa_id', $diagnosaId)
            ->first();

        if (!$d) {
            return ['success' => false, 'message' => 'Data diagnosa tidak ditemukan'];
        }

        if (empty($d->ssid_pelayanan)) {
            return ['success' => false, 'message' => 'Encounter belum disinkronkan ke SatuSehat. Kirim Encounter terlebih dahulu.'];
        }

        if (empty($d->pasien_ihs)) {
            return ['success' => false, 'message' => 'Pasien belum memiliki nomor IHS'];
        }

        $ket = 'Kunjungan ' . $d->pasien_nama . ' pada ' . Carbon::parse($d->tgl)->translatedFormat('d F Y');

        $payload = [
            'resourceType'   => 'Condition',
            'clinicalStatus' => [
                'coding' => [
                    [
                        'system'  => 'http://terminology.hl7.org/CodeSystem/condition-clinical',
                        'code'    => 'active',
                        'display' => 'Active',
                    ],
                ],
            ],
            'category' => [
                [
                    'coding' => [
                        [
                            'system'  => 'http://terminology.hl7.org/CodeSystem/condition-category',
                            'code'    => 'encounter-diagnosis',
                            'display' => 'Encounter Diagnosis',
                        ],
                    ],
                ],
            ],
            'code' => [
                'coding' => [
                    [
                        'system'  => 'http://hl7.org/fhir/sid/icd-10',
                        'code'    => $d->icd10,
                        'display' => $d->diagnosa_nama,
                    ],
                ],
            ],
            'subject' => [
                'reference' => 'Patient/' . $d->pasien_ihs,
                'display'   => $d->pasien_nama,
            ],
            'encounter' => [
                'reference' => 'Encounter/' . $d->ssid_pelayanan,
                'display'   => $ket,
            ],
        ];

        $res = $this->satusehatService->postCondition($payload);
        $satuSehatId = $res['id'] ?? null;

        if ($satuSehatId) {
            DB::connection('billing')->table('b_diagnosa')->where('diagnosa_id', $diagnosaId)->update([
                'satu_sehat_id' => $satuSehatId,
                'tgl_ssid'      => now(),
            ]);

            return [
                'success'       => true,
                'satu_sehat_id' => $satuSehatId,
                'message'       => 'Condition/Diagnosa berhasil dikirim ke SatuSehat',
            ];
        }

        return [
            'success'  => false,
            'message'  => 'Gagal mengirim Diagnosa ke SatuSehat',
            'response' => $res,
        ];
    }
}
