<?php

namespace App\Http\Controllers\Satusehat;

use App\Http\Controllers\Controller;
use App\Services\SatusehatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    /**
     * Tampilkan halaman pencarian Patient Satu Sehat FHIR R4.
     * Dukungan AJAX: jika request expects JSON, kembalikan data JSON saja
     * agar frontend bisa menampilkan animasi loading saat pencarian berlangsung.
     */
    public function index(Request $request, SatusehatService $satusehat)
    {
        $searchType = $request->query('type', 'nik');
        $searchQuery = trim($request->query('q', ''));

        $jsonResult = null;
        $error = null;

        if ($searchQuery !== '') {
            $jsonResult = $satusehat->getPatient($searchType, $searchQuery);

            if (! $jsonResult) {
                $error = 'Data pasien tidak ditemukan atau gagal terhubung ke Satu Sehat Kemenkes.';
            }
        }

        // Jika request AJAX, kembalikan JSON untuk ditampilkan frontend dengan loading
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => $jsonResult !== null,
                'searchType' => $searchType,
                'searchQuery' => $searchQuery,
                'jsonResult' => $jsonResult,
                'rawJsonString' => $jsonResult ? json_encode($jsonResult, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null,
                'compactJsonString' => $jsonResult ? json_encode($jsonResult, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null,
                'error' => $error,
            ]);
        }

        $rawJsonString = $jsonResult ? json_encode($jsonResult, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null;
        $compactJsonString = $jsonResult ? json_encode($jsonResult, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null;

        return view('satusehat.patient', compact(
            'searchType',
            'searchQuery',
            'rawJsonString',
            'compactJsonString',
            'jsonResult',
            'error'
        ));
    }
}
