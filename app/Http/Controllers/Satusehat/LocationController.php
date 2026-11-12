<?php

namespace App\Http\Controllers\Satusehat;

use App\Http\Controllers\Controller;
use App\Services\LocationService;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected LocationService $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    /**
     * Tampilkan halaman utama Master Location
     */
    public function index(Request $request)
    {
        $cari = $request->input('q') ?? $request->input('search');
        $status = $request->input('status', 'all');
        $perPage = (int) $request->input('per_page', 15);
        if ($perPage < 5 || $perPage > 100) {
            $perPage = 15;
        }

        $summary = $this->locationService->getSummary();
        $locations = $this->locationService->getPaginatedLocations($cari, $status, $perPage);

        return view('satusehat.location', compact('summary', 'locations', 'cari', 'status'));
    }

    /**
     * Endpoint API JSON untuk data tabel & AJAX
     */
    public function data(Request $request)
    {
        $cari = $request->input('q') ?? $request->input('search');
        $status = $request->input('status', 'all');
        $perPage = (int) $request->input('per_page', 15);
        if ($perPage < 5 || $perPage > 100) {
            $perPage = 15;
        }

        $locations = $this->locationService->getPaginatedLocations($cari, $status, $perPage);

        return response()->json([
            'success' => true,
            'data' => $locations->items(),
            'pagination' => [
                'current_page' => $locations->currentPage(),
                'last_page' => $locations->lastPage(),
                'per_page' => $locations->perPage(),
                'total' => $locations->total(),
            ],
            'summary' => $this->locationService->getSummary(),
        ]);
    }
}
