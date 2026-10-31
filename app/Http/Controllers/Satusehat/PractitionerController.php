<?php

namespace App\Http\Controllers\Satusehat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PractitionerController extends Controller
{
    public function index()
    {
        $summary = [
            'total_practitioners' => 86,
            'active_practitioners' => 84,
            'specialist_count' => 42,
            'last_sync' => now()->format('d M Y'),
        ];

        $practitioners = [
            [
                'id' => '1000000001',
                'ihs_number' => '1000000001',
                'nik' => '3509011204850001',
                'name' => 'dr. Hendra Pratama, Sp.PD',
                'initials' => 'HP',
                'role' => 'Dokter Spesialis',
                'specialty' => 'Spesialis Penyakit Dalam',
                'sip' => '446/089/SIP/2022',
                'str' => '35111002239481',
                'unit' => 'Poli Penyakit Dalam',
                'phone' => '+62 812-3456-7890',
                'status' => 'active',
                'status_label' => 'Terverifikasi',
                'sync_status' => 'Tersinkron',
            ],
            [
                'id' => '1000000002',
                'ihs_number' => '1000000002',
                'nik' => '3509025508880003',
                'name' => 'dr. Siti Aminah, Sp.A',
                'initials' => 'SA',
                'role' => 'Dokter Spesialis',
                'specialty' => 'Spesialis Anak (Pediatri)',
                'sip' => '446/102/SIP/2021',
                'str' => '35111003459821',
                'unit' => 'Poliklinik Anak',
                'phone' => '+62 813-9876-5432',
                'status' => 'active',
                'status_label' => 'Terverifikasi',
                'sync_status' => 'Tersinkron',
            ],
            [
                'id' => '1000000003',
                'ihs_number' => '1000000003',
                'nik' => '3509031006810002',
                'name' => 'dr. Bambang Sugiarto, Sp.JP',
                'initials' => 'BS',
                'role' => 'Dokter Spesialis',
                'specialty' => 'Spesialis Jantung & Pembuluh',
                'sip' => '446/145/SIP/2020',
                'str' => '35111001928374',
                'unit' => 'Poli Jantung & Pembuluh',
                'phone' => '+62 815-1122-3344',
                'status' => 'active',
                'status_label' => 'Terverifikasi',
                'sync_status' => 'Tersinkron',
            ],
            [
                'id' => '1000000004',
                'ihs_number' => '1000000004',
                'nik' => '3509044101900004',
                'name' => 'dr. Ratna Dewi Kusuma, Sp.OG',
                'initials' => 'RD',
                'role' => 'Dokter Spesialis',
                'specialty' => 'Spesialis Obstetri & Ginekologi',
                'sip' => '446/211/SIP/2023',
                'str' => '35111004561289',
                'unit' => 'Poli Obgyn / Kandungan',
                'phone' => '+62 817-4455-6677',
                'status' => 'active',
                'status_label' => 'Terverifikasi',
                'sync_status' => 'Tersinkron',
            ],
            [
                'id' => '1000000005',
                'ihs_number' => '1000000005',
                'nik' => '3509012307840005',
                'name' => 'dr. Ahmad Fauzi, Sp.B',
                'initials' => 'AF',
                'role' => 'Dokter Bedah',
                'specialty' => 'Spesialis Bedah Umum',
                'sip' => '446/304/SIP/2021',
                'str' => '35111002347890',
                'unit' => 'Instalasi Bedah Sentral',
                'phone' => '+62 819-2233-4455',
                'status' => 'active',
                'status_label' => 'Terverifikasi',
                'sync_status' => 'Tersinkron',
            ],
            [
                'id' => '1000000006',
                'ihs_number' => '1000000006',
                'nik' => '3509056209910002',
                'name' => 'apt. Nurul Hidayati, S.Farm',
                'initials' => 'NH',
                'role' => 'Apoteker',
                'specialty' => 'Pelayanan Farmasi Klinis',
                'sip' => '446/055/SIPA/2019',
                'str' => '19910922/STRA-KFN/2018',
                'unit' => 'Instalasi Farmasi',
                'phone' => '+62 821-3344-5566',
                'status' => 'active',
                'status_label' => 'Terverifikasi',
                'sync_status' => 'Tersinkron',
            ],
            [
                'id' => '1000000007',
                'ihs_number' => '1000000007',
                'nik' => '3509061511870001',
                'name' => 'Ns. Rudi Hartono, S.Kep',
                'initials' => 'RH',
                'role' => 'Perawat Medis',
                'specialty' => 'Keperawatan Gawat Darurat',
                'sip' => '446/189/SIPP/2022',
                'str' => '35015211984567',
                'unit' => 'Instalasi Gawat Darurat (IGD)',
                'phone' => '+62 822-7788-9900',
                'status' => 'active',
                'status_label' => 'Terverifikasi',
                'sync_status' => 'Tersinkron',
            ],
        ];

        return view('satusehat.practitioner', compact('summary', 'practitioners'));
    }
}

