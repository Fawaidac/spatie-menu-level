<?php

namespace App\Http\Controllers\Satusehat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $summary = [
            'total_location' => 24,
            'active_location' => 22,
            'total_building' => 4,
            'last_sync' => now()->format('d M Y'),
        ];

        $locations = [
            [
                'id' => 'LOC-1000293847-001',
                'fhir_id' => 'b87c0a91-23a1-4321-9d10-e51f8931a001',
                'name' => 'Ruang Periksa 1 - Poli Penyakit Dalam',
                'building' => 'Gedung Rawat Jalan Lt. 1',
                'physical_type' => 'ro (Room)',
                'organization' => 'Poliklinik Penyakit Dalam',
                'status' => 'active',
                'status_label' => 'Aktif',
                'sync_status' => 'Tersinkron',
                'phone' => '(0331) 487441 ext 121',
            ],
            [
                'id' => 'LOC-1000293847-002',
                'fhir_id' => 'c19a8b72-34b2-4432-ae21-f62a9042b002',
                'name' => 'Ruang Tindakan Resusitasi IGD',
                'building' => 'Gedung IGD Terpadu Lt. 1',
                'physical_type' => 'ro (Room)',
                'organization' => 'Instalasi Gawat Darurat (IGD)',
                'status' => 'active',
                'status_label' => 'Aktif',
                'sync_status' => 'Tersinkron',
                'phone' => '(0331) 487441 ext 118',
            ],
            [
                'id' => 'LOC-1000293847-003',
                'fhir_id' => 'd20b9c83-45c3-4543-bf32-a73b0153c003',
                'name' => 'Ruang Periksa Anak (Pediatrik)',
                'building' => 'Gedung Rawat Jalan Lt. 1',
                'physical_type' => 'ro (Room)',
                'organization' => 'Poliklinik Anak',
                'status' => 'active',
                'status_label' => 'Aktif',
                'sync_status' => 'Tersinkron',
                'phone' => '(0331) 487441 ext 124',
            ],
            [
                'id' => 'LOC-1000293847-004',
                'fhir_id' => 'e31c0d94-56d4-4654-c043-b84c1264d004',
                'name' => 'Ruang Pemeriksaan Jantung & EKG',
                'building' => 'Gedung Diagnostik Terpadu Lt. 2',
                'physical_type' => 'ro (Room)',
                'organization' => 'Poli Jantung & Pembuluh',
                'status' => 'active',
                'status_label' => 'Aktif',
                'sync_status' => 'Tersinkron',
                'phone' => '(0331) 487441 ext 128',
            ],
            [
                'id' => 'LOC-1000293847-005',
                'fhir_id' => 'f42d1e05-67e5-4765-d154-c95d2375e005',
                'name' => 'Kamar Rawat Inap Melati 101',
                'building' => 'Gedung Paviliun Melati Lt. 1',
                'physical_type' => 'bd (Bed)',
                'organization' => 'Instalasi Rawat Inap (IRNA)',
                'status' => 'active',
                'status_label' => 'Aktif',
                'sync_status' => 'Tersinkron',
                'phone' => '(0331) 487441 ext 201',
            ],
            [
                'id' => 'LOC-1000293847-006',
                'fhir_id' => 'a53e2f16-78f6-4876-e265-da6e3486f006',
                'name' => 'Depo Obat & Farmasi Rawat Jalan',
                'building' => 'Gedung Rawat Jalan Lt. 1',
                'physical_type' => 'ro (Room)',
                'organization' => 'Instalasi Farmasi',
                'status' => 'active',
                'status_label' => 'Aktif',
                'sync_status' => 'Tersinkron',
                'phone' => '(0331) 487441 ext 105',
            ],
            [
                'id' => 'LOC-1000293847-007',
                'fhir_id' => 'b64f3a27-89a7-4987-f376-eb7f4597a007',
                'name' => 'Laboratorium Hematologi & Patologi',
                'building' => 'Gedung Diagnostik Terpadu Lt. 1',
                'physical_type' => 'ro (Room)',
                'organization' => 'Laboratorium Klinik',
                'status' => 'active',
                'status_label' => 'Aktif',
                'sync_status' => 'Tersinkron',
                'phone' => '(0331) 487441 ext 112',
            ],
            [
                'id' => 'LOC-1000293847-008',
                'fhir_id' => 'c75a4b38-90b8-4098-a487-fc8a5608b008',
                'name' => 'Ruang Radiologi & CT Scan',
                'building' => 'Gedung Diagnostik Terpadu Lt. 1',
                'physical_type' => 'ro (Room)',
                'organization' => 'Instalasi Radiologi',
                'status' => 'suspended',
                'status_label' => 'Pemeliharaan',
                'sync_status' => 'Tersinkron',
                'phone' => '(0331) 487441 ext 115',
            ],
        ];

        return view('satusehat.location', compact('summary', 'locations'));
    }
}

