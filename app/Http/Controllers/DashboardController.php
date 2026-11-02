<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman Dashboard dan rekap pengiriman data Satu Sehat.
     *
     * Halaman langsung dirender tanpa data berat agar cepat muncul.
     * Data diisi via AJAX melalui route dashboard.data setelah halaman render.
     */
    public function index()
    {
        return view('dashboard.index');
    }

    /**
     * Ambil data dashboard dalam bentuk JSON (untuk dipanggil via AJAX setelah halaman render),
     * sehingga halaman bisa langsung muncul dengan stats 0 dan tabel loading.
     */
    public function data()
    {
        // 1. Subquery untuk menghitung diagnosa terkirim per pelayanan
        $subDiagnosa = DB::connection('billing')
            ->table('b_diagnosa')
            ->selectRaw('count(*)')
            ->whereColumn('b_diagnosa.pelayanan_id', 'b_pelayanan.id')
            ->where('b_diagnosa.satu_sehat_id', '<>', '');

        // 2. Subquery utama data pelayanan
        $subPelayanan = DB::connection('billing')
            ->table('b_pelayanan')
            ->select([
                'id',
                DB::raw("DATE_FORMAT(tgl_ssid, '%Y-%m-%d') as tgl_ssid"),
                DB::raw('1 as jumlah'),
                DB::raw("({$subDiagnosa->toSql()}) as diagnosa"),
            ])
            ->mergeBindings($subDiagnosa)
            ->where('satu_sehat_id', '<>', '');

        // 3. Query Rekap Data Tabel (Limit 60 hari)
        $daftarTerkirim = DB::connection('billing')
            ->table(DB::raw("({$subPelayanan->toSql()}) as dat"))
            ->mergeBindings($subPelayanan)
            ->select([
                DB::raw("DATE_FORMAT(dat.tgl_ssid, '%Y-%m-%d') as tanggal"),
                DB::raw('SUM(dat.jumlah) as encounter'),
                DB::raw('SUM(dat.diagnosa) as diagnosa'),
            ])
            ->groupBy(DB::raw("DATE_FORMAT(dat.tgl_ssid, '%Y-%m-%d')"))
            ->orderBy(DB::raw("DATE_FORMAT(dat.tgl_ssid, '%Y-%m-%d')"), 'desc')
            ->limit(60)
            ->get();

        // 4. Kalkulasi Data Kartu Statistik (Summary Stats)
        $totalEncounter = (int) $daftarTerkirim->sum('encounter');
        $totalDiagnosa = (int) $daftarTerkirim->sum('diagnosa');
        $hariTercatat = (int) $daftarTerkirim->count();

        // Ambil tanggal paling akhir (terbaru)
        $lastSyncRaw = $daftarTerkirim->first()?->tanggal;
        $sinkronisasiTerakhir = $lastSyncRaw
            ? Carbon::parse($lastSyncRaw)->locale('id')->translatedFormat('d M Y')
            : '-';

        return response()->json([
            'total_encounter'       => $totalEncounter,
            'total_diagnosa'        => $totalDiagnosa,
            'hari_tercatat'         => $hariTercatat,
            'sinkronisasi_terakhir' => $sinkronisasiTerakhir,
            'daftar_terkirim'       => $daftarTerkirim->map(function ($row) {
                return [
                    'tanggal'   => $row->tanggal,
                    'encounter' => (int) $row->encounter,
                    'diagnosa'  => (int) $row->diagnosa,
                ];
            }),
        ]);
    }
    }

