<?php

namespace App\Http\Controllers\Encounter;

use App\Http\Controllers\Controller;
use App\Services\EncounterService;
use Illuminate\Http\Request;

class EncounterController extends Controller
{
    protected EncounterService $encounterService;

    public function __construct(EncounterService $encounterService)
    {
        $this->encounterService = $encounterService;
    }

    /**
     * Halaman Encounter Rawat Jalan
     */
    public function rawatJalan(Request $request)
    {
        $filter = [
            'tgl_periksa'    => $request->input('tgl_periksa', now()->format('Y-m-d')),
            'tempat_layanan' => $request->input('tempat_layanan', 'all'),
            'status'         => $request->input('status', 'all'),
            'no_rm'          => $request->input('no_rm', ''),
        ];

        $tempat_options = $this->encounterService->getUnits('jalan');
        $patients       = $this->encounterService->getEncounters('jalan', $filter, 15);
        $summary        = $this->encounterService->getSummary('jalan', $filter);

        $status_options = [
            'all'     => 'Semua Status',
            'datang'  => 'Datang (Masih Dilayani)',
            'pulang'  => 'Pulang (Selesai)',
            'synced'  => 'Tersinkron SatuSehat',
            'pending' => 'Belum Sinkron',
        ];

        return view('encounter.rawat-jalan', compact(
            'summary', 'filter', 'patients', 'tempat_options', 'status_options'
        ));
    }

    /**
     * Halaman Encounter IGD (Rawat Darurat)
     */
    public function igd(Request $request)
    {
        $filter = [
            'tgl_periksa'    => $request->input('tgl_periksa', now()->format('Y-m-d')),
            'tempat_layanan' => $request->input('tempat_layanan', 'all'),
            'status'         => $request->input('status', 'all'),
            'no_rm'          => $request->input('no_rm', ''),
        ];

        $tempat_options = $this->encounterService->getUnits('igd');
        $patients       = $this->encounterService->getEncounters('igd', $filter, 15);
        $summary        = $this->encounterService->getSummary('igd', $filter);

        $status_options = [
            'all'     => 'Semua Status',
            'datang'  => 'Datang (Observasi IGD)',
            'pulang'  => 'Pulang / Selesai',
            'synced'  => 'Tersinkron SatuSehat',
            'pending' => 'Belum Sinkron',
        ];

        return view('encounter.igd', compact(
            'summary', 'filter', 'patients', 'tempat_options', 'status_options'
        ));
    }

    /**
     * Halaman Encounter Rawat Inap
     */
    public function rawatInap(Request $request)
    {
        $filter = [
            'tgl_periksa'    => $request->input('tgl_periksa', now()->format('Y-m-d')),
            'tempat_layanan' => $request->input('tempat_layanan', 'all'),
            'status'         => $request->input('status', 'all'),
            'no_rm'          => $request->input('no_rm', ''),
        ];

        $tempat_options = $this->encounterService->getUnits('inap');
        $patients       = $this->encounterService->getEncounters('inap', $filter, 15);
        $summary        = $this->encounterService->getSummary('inap', $filter);

        $status_options = [
            'all'     => 'Semua Status',
            'datang'  => 'Masih Dirawat',
            'pulang'  => 'Sudah Keluar / Pulang',
            'synced'  => 'Tersinkron SatuSehat',
            'pending' => 'Belum Sinkron',
        ];

        return view('encounter.rawat-inap', compact(
            'summary', 'filter', 'patients', 'tempat_options', 'status_options'
        ));
    }

    /**
     * Endpoint API JSON untuk detail pelayanan (Diagnosa, Tindakan, Resep)
     */
    public function detail(int $id)
    {
        $data = $this->encounterService->getPelayananDetail($id);

        if (empty($data)) {
            return response()->json(['success' => false, 'message' => 'Data pelayanan tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $data]);
    }

    /**
     * Endpoint Kirim Encounter ke SatuSehat
     */
    public function send(Request $request)
    {
        $request->validate([
            'pelayanan_id' => 'required|integer',
            'type'         => 'nullable|string|in:jalan,igd,inap',
        ]);

        $pelayananId = (int) $request->input('pelayanan_id');
        $type        = $request->input('type', 'jalan');

        $result = $this->encounterService->sendEncounter($pelayananId, $type);

        return response()->json($result);
    }

    /**
     * Endpoint Kirim Diagnosa (Condition) ke SatuSehat
     */
    public function sendCondition(Request $request)
    {
        $request->validate([
            'diagnosa_id' => 'required|integer',
        ]);

        $diagnosaId = (int) $request->input('diagnosa_id');
        $result = $this->encounterService->sendCondition($diagnosaId);

        return response()->json($result);
    }
}
