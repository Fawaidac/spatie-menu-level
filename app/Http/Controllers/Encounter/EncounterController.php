<?php

namespace App\Http\Controllers\Encounter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EncounterController extends Controller
{
    /**
     * Data pasien mock yang dipakai di semua sub-encounter.
     */
    private function makePatients(string $unit, string $doctorName, array $extraFields = []): array
    {
        $names = [
            ['NUR ALIFAH MUTIARA KASIH', 'P', '00000422815', '3509214310190001', 'P00254104422'],
            ['RIFATUL HASANAH BY NY L', 'P', '00000499811', '3509215086086676', null],
            ['IDA ROYANI BY NY L',        'P', '00000502020', null, null],
            ['MUHAMMAD ULUMIDDIN L',       'L', '00000498063', '3509221005240001', null],
            ['MUHAMMAD HAFIS NUR ALBIYAN', 'L', '00000504550', '3509242612160001', 'P10531785218'],
            ['FITRI YULIANA BY NY P',      'P', '00000503451', '3509224803190001', null],
            ['NAKHLA AS SYIFA HISABILLAH', 'P', '00000500829', '3509174811250001', null],
            ['QIANA RAFANDA',              'P', '00000477749', '3509304602230004', null],
        ];

        $statuses = ['Encounter', 'Encounter Success', 'Encounter'];

        $rows = [];
        $hour = 14;
        $min  = 43;

        foreach ($names as $i => [$name, $gender, $rm, $nik, $noRM]) {
            $hour = max(8, $hour - rand(0, 1));
            $min  = rand(0, 59);
            $tgl  = now()->format('d-m-Y');
            $time = sprintf('%02d:%02d:%02d', $hour - $i, $min, rand(0, 59));

            $row = [
                'no'         => $i + 1,
                'tgl'        => $tgl . ' ' . $time,
                'rm_no'      => $rm,
                'nik'        => $nik,
                'no_rm'      => $noRM,
                'name'       => $name,
                'gender'     => $gender,
                'initial'    => strtoupper(substr($name, 0, 1) . substr(strrchr($name, ' ') ?: $name, 1, 1)),
                'doctor'     => $doctorName,
                'doctor_id'  => '3509' . rand(100000000, 999999999) . '002',
                'ihs'        => '1000' . rand(1000000, 9999999),
                'unit'       => $unit,
                'action_status' => ($i === 0 || $i === 4 || $i === 5) ? 'success' : 'pending',
            ];

            foreach ($extraFields as $k => $v) {
                $row[$k] = $v;
            }

            $rows[] = $row;
        }

        return $rows;
    }

    public function rawatJalan(Request $request)
    {
        $summary = [
            'total_encounter'  => 1247,
            'berhasil'         => 1231,
            'pending'          => 16,
            'last_sync'        => now()->format('d M Y, H:i'),
        ];

        $filter = [
            'tgl_periksa'    => $request->input('tgl_periksa', now()->format('Y-m-d')),
            'jenis_layanan'  => $request->input('jenis_layanan', 'RAWAT JALAN'),
            'tempat_layanan' => $request->input('tempat_layanan', 'ANAK, KLINIK SP.'),
            'status'         => $request->input('status', 'Pulang'),
            'no_rm'          => $request->input('no_rm', ''),
        ];

        $patients = $this->makePatients('Poli Anak & Rawat Jalan', 'dr. Muhammad Ali Shodikin, Sp.A.', [
            'poli' => 'ANAK, KLINIK SP.',
        ]);

        $jenis_options    = ['RAWAT JALAN', 'RAWAT INAP', 'IGD'];
        $tempat_options   = ['ANAK, KLINIK SP.', 'PENYAKIT DALAM, KLINIK SP.', 'BEDAH, KLINIK SP.', 'JANTUNG, KLINIK SP.'];
        $status_options   = ['Pulang', 'Dirujuk', 'Meninggal', 'Masih Dirawat'];

        return view('encounter.rawat-jalan', compact(
            'summary', 'filter', 'patients', 'jenis_options', 'tempat_options', 'status_options'
        ));
    }

    public function igd(Request $request)
    {
        $summary = [
            'total_encounter' => 312,
            'berhasil'        => 308,
            'pending'         => 4,
            'last_sync'       => now()->format('d M Y, H:i'),
        ];

        $filter = [
            'tgl_periksa'  => $request->input('tgl_periksa', now()->format('Y-m-d')),
            'jenis_layanan'=> $request->input('jenis_layanan', 'IGD'),
            'triase'       => $request->input('triase', 'Semua Triase'),
            'status'       => $request->input('status', 'Pulang'),
            'no_rm'        => $request->input('no_rm', ''),
        ];

        $patients = $this->makePatients('IGD Terpadu', 'dr. Rudi Santoso, Sp.EM.', [
            'poli'   => 'IGD',
            'triase' => ['Merah', 'Kuning', 'Hijau', 'Hitam', 'Kuning', 'Hijau', 'Merah', 'Kuning'][\rand(0,7)] ?? 'Kuning',
        ]);

        // Override triase per row
        $triases = ['Merah', 'Kuning', 'Hijau', 'Kuning', 'Merah', 'Hijau', 'Kuning', 'Hijau'];
        foreach ($patients as $i => &$p) {
            $p['triase'] = $triases[$i] ?? 'Hijau';
        }
        unset($p);

        $triase_options = ['Semua Triase', 'Merah', 'Kuning', 'Hijau', 'Hitam'];
        $status_options = ['Pulang', 'Rawat Inap', 'Rujuk', 'Meninggal'];

        return view('encounter.igd', compact(
            'summary', 'filter', 'patients', 'triase_options', 'status_options'
        ));
    }

    public function rawatInap(Request $request)
    {
        $summary = [
            'total_encounter' => 489,
            'berhasil'        => 479,
            'pending'         => 10,
            'last_sync'       => now()->format('d M Y, H:i'),
        ];

        $filter = [
            'tgl_periksa'    => $request->input('tgl_periksa', now()->format('Y-m-d')),
            'jenis_layanan'  => $request->input('jenis_layanan', 'RAWAT INAP'),
            'ruang'          => $request->input('ruang', 'Melati'),
            'status'         => $request->input('status', 'Masih Dirawat'),
            'no_rm'          => $request->input('no_rm', ''),
        ];

        $patients = $this->makePatients('Rawat Inap Melati', 'dr. Hendra Pratama, Sp.PD.', [
            'poli'  => 'RAWAT INAP',
        ]);

        // Override with inpatient-specific fields
        $kamar = ['Melati 101', 'Melati 102', 'Melati 103', 'Melati 201', 'Mawar 101', 'Mawar 102', 'Melati 104', 'Mawar 103'];
        $lama  = [3, 1, 5, 2, 7, 4, 1, 6];
        foreach ($patients as $i => &$p) {
            $p['kamar']      = $kamar[$i] ?? 'Melati 101';
            $p['lama_rawat'] = $lama[$i] ?? 1;
        }
        unset($p);

        $ruang_options  = ['Melati', 'Mawar', 'Anggrek', 'ICU', 'NICU', 'HCU', 'Isolasi'];
        $status_options = ['Masih Dirawat', 'Pulang', 'Rujuk', 'Meninggal', 'APS'];

        return view('encounter.rawat-inap', compact(
            'summary', 'filter', 'patients', 'ruang_options', 'status_options'
        ));
    }
}

