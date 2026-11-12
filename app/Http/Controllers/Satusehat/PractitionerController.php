<?php

namespace App\Http\Controllers\Satusehat;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Services\SatusehatService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PractitionerController extends Controller
{
    /**
     * Tampilkan data tenaga medis (Practitioner) dari database RSD dr. Soebandi.
     * Menggantikan practitioner.php dan practitioner_list.php native.
     */
    public function index(Request $request): View|JsonResponse
    {
        $cari = trim($request->input('q', $request->input('cari', '')));
        $statusFilter = $request->input('status', 'all');

        // Query dasar dari database billing (tabel b_ms_pegawai join b_ms_pegawai_jenis)
        $query = Pegawai::query()
            ->leftJoin('b_ms_pegawai_jenis', 'b_ms_pegawai_jenis.id', '=', 'b_ms_pegawai.pegawai_jenis')
            ->select([
                'b_ms_pegawai.id',
                'b_ms_pegawai.nik',
                'b_ms_pegawai.no_ihs',
                'b_ms_pegawai.nama_ihs',
                'b_ms_pegawai.nama',
                'b_ms_pegawai_jenis.Nama as jenis',
                'b_ms_pegawai.spesialisasi',
                'b_ms_pegawai.no_sip',
                'b_ms_pegawai.nip',
                'b_ms_pegawai.hp',
                'b_ms_pegawai.telp',
            ])
            ->whereNotNull('b_ms_pegawai.nik')
            ->where('b_ms_pegawai.nik', '<>', '')
            ->whereNotIn('b_ms_pegawai.nik', ['.', '-']);

        // Filter pencarian berdasarkan nama, NIK, IHS, atau spesialisasi
        if ($cari !== '') {
            $query->where(function ($q) use ($cari) {
                $q->where('b_ms_pegawai.nama', 'like', "%{$cari}%")
                    ->orWhere('b_ms_pegawai.nik', 'like', "%{$cari}%")
                    ->orWhere('b_ms_pegawai.no_ihs', 'like', "%{$cari}%")
                    ->orWhere('b_ms_pegawai.nama_ihs', 'like', "%{$cari}%")
                    ->orWhere('b_ms_pegawai_jenis.Nama', 'like', "%{$cari}%");
            });
        }

        // Filter status verifikasi / IHS
        if ($statusFilter === 'active') {
            $query->whereNotNull('b_ms_pegawai.no_ihs')->where('b_ms_pegawai.no_ihs', '<>', '');
        } elseif ($statusFilter === 'unmapped') {
            $query->where(function ($q) {
                $q->whereNull('b_ms_pegawai.no_ihs')->orWhere('b_ms_pegawai.no_ihs', '');
            });
        }

        // Urutkan dokter yang sudah punya IHS terlebih dahulu atau berdasarkan nama
        $query->orderByRaw("CASE WHEN b_ms_pegawai.no_ihs IS NOT NULL AND b_ms_pegawai.no_ihs <> '' THEN 0 ELSE 1 END, b_ms_pegawai.nama ASC");

        $paginator = $query->paginate(15)->withQueryString();

        // Hitung statistik summary riil dari database billing
        $totalPractitioners = DB::connection('billing')
            ->table('b_ms_pegawai')
            ->whereNotNull('nik')
            ->where('nik', '<>', '')
            ->whereNotIn('nik', ['.', '-'])
            ->count();

        $activePractitioners = DB::connection('billing')
            ->table('b_ms_pegawai')
            ->whereNotNull('nik')
            ->where('nik', '<>', '')
            ->whereNotNull('no_ihs')
            ->where('no_ihs', '<>', '')
            ->count();

        $specialistCount = DB::connection('billing')
            ->table('b_ms_pegawai')
            ->where(function ($q) {
                $q->where('spesialisasi', '<>', '')
                    ->whereNotNull('spesialisasi')
                    ->orWhere('nama', 'like', '%Sp.%');
            })
            ->count();

        $summary = [
            'total_practitioners' => number_format($totalPractitioners),
            'active_practitioners' => number_format($activePractitioners),
            'specialist_count' => number_format($specialistCount),
            'last_sync' => Carbon::now()->translatedFormat('d M Y, H:i'),
        ];

        // Format data untuk tabel view Blade
        $practitioners = $paginator->through(function ($row) {
            $displayName = $row->nama ?: ($row->nama_ihs ?: 'Tanpa Nama');

            $initials = '';
            $nameParts = preg_split('/\s+/', trim($displayName));
            foreach (array_slice($nameParts, 0, 2) as $part) {
                $initials .= strtoupper(substr($part, 0, 1));
            }

            $hasIhs = ! empty($row->no_ihs);

            return [
                'id' => (string) $row->id,
                'ihs_number' => $hasIhs ? $row->no_ihs : '-',
                'nik' => $row->nik,
                'name' => $displayName,
                'nama_ihs' => $row->nama_ihs ?: '-',
                'initials' => $initials ?: 'DR',
                'role' => $row->jenis ?: 'Tenaga Kesehatan',
                'specialty' => $row->spesialisasi ?: ($row->jenis ?: 'Dokter Umum'),
                'sip' => $row->no_sip ?: '-',
                'str' => $row->nip ?: '-',
                'unit' => 'RSUD dr. Soebandi',
                'phone' => $row->hp ?: ($row->telp ?: '-'),
                'status' => $hasIhs ? 'active' : 'inactive',
                'status_label' => $hasIhs ? 'Terverifikasi' : 'Belum Sinkron',
            ];
        });

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'summary' => $summary,
                'practitioners' => $practitioners,
            ]);
        }

        return view('satusehat.practitioner', compact('summary', 'practitioners', 'cari'));
    }

    /**
     * Sinkronisasi data tenaga medis ke SATUSEHAT Kemenkes.
     * Menggantikan practitioner_update.php native.
     */
    public function sync(Request $request, SatusehatService $satusehat): JsonResponse
    {
        $nik = trim($request->input('nik', ''));
        $status = $request->input('status', 'tambah');
        $ssid = trim($request->input('ssid', $request->input('no_ihs', '')));

        if ($status === 'update' && ! empty($ssid)) {
            // Ambil data dari SATUSEHAT berdasarkan IHS ID
            $data = $satusehat->getPractitionerById($ssid);

            if (! $data || isset($data['issue'])) {
                $detail = $data['issue'][0]['details']['text'] ?? 'Data IHS tidak ditemukan di SATUSEHAT';
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui: ' . $detail,
                ], 422);
            }

            $noIhs = $ssid;
            $namaIhs = $data['name'][0]['text'] ?? ($data['entry'][0]['resource']['name'][0]['text'] ?? '');
        } else {
            // Ambil data dari SATUSEHAT berdasarkan NIK
            if (empty($nik)) {
                return response()->json([
                    'success' => false,
                    'message' => 'NIK tenaga medis wajib diisi',
                ], 422);
            }

            $data = $satusehat->getPractitionerByNik($nik);

            if (! $data || empty($data['entry'])) {
                return response()->json([
                    'success' => false,
                    'message' => "Data NIK {$nik} tidak ditemukan pada server SATUSEHAT Kemkes",
                ], 404);
            }

            $resource = $data['entry'][0]['resource'] ?? [];
            $noIhs = $resource['id'] ?? null;
            $namaIhs = $resource['name'][0]['text'] ?? '';
        }

        if ($noIhs) {
            // Update database lokal (koneksi billing tabel b_ms_pegawai)
            DB::connection('billing')
                ->table('b_ms_pegawai')
                ->where('nik', $nik)
                ->update([
                    'no_ihs' => $noIhs,
                    'nama_ihs' => $namaIhs,
                ]);

            return response()->json([
                'success' => true,
                'no_ihs' => $noIhs,
                'nama_ihs' => $namaIhs,
                'message' => "Berhasil sinkronisasi IHS Kemenkes: {$namaIhs} (IHS: {$noIhs})",
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Nomor IHS tidak ditemukan pada respons SATUSEHAT',
        ], 422);
    }
}
