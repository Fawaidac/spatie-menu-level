<?php

namespace App\Http\Controllers\Satusehat;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Services\SatusehatService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MedicationController extends Controller
{
    /**
     * Tampilkan data obat dan status pemetaan SATUSEHAT FHIR Medication.
     * Menggantikan medication.php dan medication_list.php native.
     */
    public function index(Request $request): View|JsonResponse
    {
        $cari = trim($request->input('q', $request->input('cari', '')));
        $statusFilter = $request->input('status', 'all');

        // Query database apotek tabel a_obat
        $query = Obat::query();

        // Filter pencarian berdasarkan nama obat, generik, atau KFA ID/nama
        if ($cari !== '') {
            $query->where(function ($q) use ($cari) {
                $q->where('OBAT_NAMA', 'like', "%{$cari}%")
                    ->orWhere('OBAT_NAMA_GENERIK', 'like', "%{$cari}%")
                    ->orWhere('kfa_id', 'like', "%{$cari}%")
                    ->orWhere('kfa_name', 'like', "%{$cari}%")
                    ->orWhere('satu_sehat_id', 'like', "%{$cari}%");
            });
        }

        // Filter status
        if ($statusFilter === 'synced') {
            $query->whereNotNull('satu_sehat_id')->where('satu_sehat_id', '<>', '');
        } elseif ($statusFilter === 'unmapped') {
            $query->where(function ($q) {
                $q->whereNull('satu_sehat_id')->orWhere('satu_sehat_id', '');
            });
        } elseif ($statusFilter === 'kfa_only') {
            $query->whereNotNull('kfa_id')->where('kfa_id', '<>', '');
        }

        // Prioritaskan obat yang sudah memiliki KFA / SatuSehat ID
        $query->orderByRaw("
            CASE 
                WHEN satu_sehat_id IS NOT NULL AND satu_sehat_id <> '' THEN 0
                WHEN kfa_id IS NOT NULL AND kfa_id <> '' THEN 1
                ELSE 2
            END, OBAT_ID ASC
        ");

        $paginator = $query->paginate(15)->withQueryString();

        // Ringkasan metrik riil dari database apotek
        $totalMedications = DB::connection('apotek')->table('a_obat')->count();

        $mappedKfa = DB::connection('apotek')
            ->table('a_obat')
            ->whereNotNull('kfa_id')
            ->where('kfa_id', '<>', '')
            ->count();

        $syncedSatusehat = DB::connection('apotek')
            ->table('a_obat')
            ->whereNotNull('satu_sehat_id')
            ->where('satu_sehat_id', '<>', '')
            ->count();

        $lastSyncDate = DB::connection('apotek')
            ->table('a_obat')
            ->whereNotNull('tgl_ssid')
            ->orderByDesc('tgl_ssid')
            ->value('tgl_ssid');

        $summary = [
            'total_medications' => number_format($totalMedications),
            'mapped_kfa' => number_format($mappedKfa),
            'hard_drugs' => number_format($syncedSatusehat),
            'last_sync' => $lastSyncDate ? Carbon::parse($lastSyncDate)->translatedFormat('d M Y, H:i') : 'Belum Ada',
        ];

        // Format data untuk tabel view Blade
        $medications = $paginator->through(function ($row) {
            $hasSsid = ! empty($row->satu_sehat_id);
            $hasKfa = ! empty($row->kfa_id);

            $kfaName = ! empty($row->kfa_name) ? $row->kfa_name : ($row->OBAT_NAMA ?: '-');
            $numVal = ! empty($row->numerator_value) ? $row->numerator_value : '1';
            $numCode = ! empty($row->numerator_code) ? $row->numerator_code : 'mg';
            $denVal = ! empty($row->denominator_value) ? $row->denominator_value : '1';
            $denCode = ! empty($row->denominator_code) ? $row->denominator_code : 'TAB';

            return [
                'id' => (string) $row->OBAT_ID,
                'name' => $row->OBAT_NAMA ?: '-',
                'generic_name' => $row->OBAT_NAMA_GENERIK ?: '-',
                'strength' => "{$numVal} {$numCode} / {$denVal} {$denCode}",
                'numerator_value' => $numVal,
                'numerator_code' => $numCode,
                'denominator_value' => $denVal,
                'denominator_code' => $denCode,
                'kfa_code' => $hasKfa ? $row->kfa_id : '-',
                'kfa_name' => $kfaName,
                'dose_form' => $row->OBAT_BENTUK ?: 'Tablet',
                'dose_form_code' => 'BS066',
                'category' => $hasSsid ? 'Terdaftar SATUSEHAT' : ($hasKfa ? 'KFA Terpetakan' : 'Belum Terpetakan'),
                'category_tone' => $hasSsid ? 'green' : ($hasKfa ? 'blue' : 'amber'),
                'manufacturer' => 'RSUD dr. Soebandi',
                'status' => $hasSsid ? 'active' : 'draft',
                'status_label' => $hasSsid ? 'Tersinkron' : 'Belum Kirim',
                'satu_sehat_id' => $hasSsid ? $row->satu_sehat_id : '-',
                'tgl_ssid' => $row->tgl_ssid ? Carbon::parse($row->tgl_ssid)->format('d/m/Y H:i') : '-',
            ];
        });

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'summary' => $summary,
                'medications' => $medications,
            ]);
        }

        return view('satusehat.medication', compact('summary', 'medications', 'cari'));
    }

    /**
     * Kirim/Sinkronisasi obat (Resource FHIR Medication) ke SATUSEHAT.
     * Menggantikan medication_update.php native.
     */
    public function sync(Request $request, SatusehatService $satusehat): JsonResponse
    {
        $id = $request->input('id');

        if (empty($id)) {
            return response()->json([
                'success' => false,
                'message' => 'ID obat wajib disertakan',
            ], 422);
        }

        $obat = DB::connection('apotek')->table('a_obat')->where('OBAT_ID', $id)->first();

        if (! $obat) {
            return response()->json([
                'success' => false,
                'message' => 'Data obat tidak ditemukan di database Apotek',
            ], 404);
        }

        $kfaId = trim($request->input('kfa_id', $obat->kfa_id ?? ''));
        $kfaName = trim($request->input('kfa_name', $obat->kfa_name ?? ''));

        if (empty($kfaName)) {
            $kfaName = $obat->OBAT_NAMA;
        }

        if (empty($kfaId)) {
            return response()->json([
                'success' => false,
                'message' => 'Kode KFA Kemenkes belum ditentukan untuk obat ini',
            ], 422);
        }

        $numeratorVal = (float) $request->input('numerator_value', $obat->numerator_value ?: 1);
        $numeratorCode = trim($request->input('numerator_code', $obat->numerator_code ?: 'mg'));
        $denominatorVal = (float) $request->input('denominator_value', $obat->denominator_value ?: 1);
        $denominatorCode = trim($request->input('denominator_code', $obat->denominator_code ?: 'TAB'));

        $orgId = $satusehat->getOrganizationId();

        if (! $orgId) {
            return response()->json([
                'success' => false,
                'message' => 'ID Organisasi SATUSEHAT belum dikonfigurasi di profil rumah sakit',
            ], 422);
        }

        // Susun payload FHIR Medication sesuai standar SATUSEHAT Kemenkes & skrip native
        $payload = [
            'resourceType' => 'Medication',
            'meta' => [
                'profile' => [
                    'https://fhir.kemkes.go.id/r4/StructureDefinition/Medication',
                ],
            ],
            'identifier' => [
                [
                    'system' => 'http://sys-ids.kemkes.go.id/medication/' . $orgId,
                    'use' => 'official',
                    'value' => (string) $id,
                ],
            ],
            'code' => [
                'coding' => [],
            ],
            'status' => 'active',
            'manufacturer' => [
                'reference' => 'Organization/' . $orgId,
            ],
            'form' => [
                'coding' => [
                    [
                        'system' => 'http://terminology.kemkes.go.id/CodeSystem/medication-form',
                        'code' => 'BS066',
                        'display' => $obat->OBAT_BENTUK ?: 'Tablet',
                    ],
                ],
            ],
            'ingredient' => [
                [
                    'itemCodeableConcept' => [
                        'coding' => [
                            [
                                'system' => 'http://sys-ids.kemkes.go.id/kfa',
                                'code' => (string) $kfaId,
                                'display' => (string) $kfaName,
                            ],
                        ],
                    ],
                    'isActive' => true,
                    'strength' => [
                        'numerator' => [
                            'value' => $numeratorVal,
                            'system' => 'http://unitsofmeasure.org',
                            'code' => (string) $numeratorCode,
                        ],
                        'denominator' => [
                            'value' => $denominatorVal,
                            'system' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm',
                            'code' => (string) $denominatorCode,
                        ],
                    ],
                ],
            ],
            'extension' => [
                [
                    'url' => 'https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationType',
                    'valueCodeableConcept' => [
                        'coding' => [
                            [
                                'system' => 'http://terminology.kemkes.go.id/CodeSystem/medication-type',
                                'code' => 'NC',
                                'display' => 'Non-compound',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $response = $satusehat->postMedication($payload);
        $satuSehatId = $response['id'] ?? null;

        if ($satuSehatId) {
            $now = Carbon::now()->format('Y-m-d H:i:s');

            // Simpan SatuSehat ID ke tabel a_obat di database Apotek
            DB::connection('apotek')
                ->table('a_obat')
                ->where('OBAT_ID', $id)
                ->update([
                    'kfa_id' => $kfaId,
                    'kfa_name' => $kfaName,
                    'numerator_value' => (string) $numeratorVal,
                    'numerator_code' => $numeratorCode,
                    'denominator_value' => (string) $denominatorVal,
                    'denominator_code' => $denominatorCode,
                    'satu_sehat_id' => $satuSehatId,
                    'tgl_ssid' => $now,
                ]);

            return response()->json([
                'success' => true,
                'satu_sehat_id' => $satuSehatId,
                'tgl_ssid' => Carbon::parse($now)->format('d/m/Y H:i'),
                'message' => "Berhasil mengirim Medication ke SATUSEHAT! ID: {$satuSehatId}",
            ]);
        }

        $detail = $response['issue'][0]['details']['text'] ?? ($response['message'] ?? 'Gagal membuat resource Medication di SATUSEHAT');

        return response()->json([
            'success' => false,
            'message' => 'Gagal mengirim ke SATUSEHAT: ' . $detail,
            'response' => $response,
        ], 422);
    }
}
