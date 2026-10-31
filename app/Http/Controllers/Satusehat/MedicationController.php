<?php

namespace App\Http\Controllers\Satusehat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function index()
    {
        $summary = [
            'total_medications' => 340,
            'mapped_kfa' => 332,
            'hard_drugs' => 184,
            'last_sync' => now()->format('d M Y'),
        ];

        $medications = [
            [
                'id' => 'MED-001',
                'kfa_code' => '93001024',
                'name' => 'Paracetamol 500 mg Tablet',
                'dose_form' => 'Tablet',
                'dose_form_code' => 'TAB',
                'strength' => '500 mg',
                'category' => 'Obat Bebas',
                'category_tone' => 'green',
                'manufacturer' => 'PT Kimia Farma',
                'status' => 'active',
                'status_label' => 'Terpetakan KFA',
                'sync_status' => 'Tersinkron',
            ],
            [
                'id' => 'MED-002',
                'kfa_code' => '93002341',
                'name' => 'Amoxicillin 500 mg Kapsul',
                'dose_form' => 'Kapsul',
                'dose_form_code' => 'CAP',
                'strength' => '500 mg',
                'category' => 'Antibiotik / Keras',
                'category_tone' => 'red',
                'manufacturer' => 'PT Kalbe Farma',
                'status' => 'active',
                'status_label' => 'Terpetakan KFA',
                'sync_status' => 'Tersinkron',
            ],
            [
                'id' => 'MED-003',
                'kfa_code' => '93005512',
                'name' => 'Amlodipine Besylate 10 mg Tablet',
                'dose_form' => 'Tablet',
                'dose_form_code' => 'TAB',
                'strength' => '10 mg',
                'category' => 'Obat Keras',
                'category_tone' => 'red',
                'manufacturer' => 'PT Dexa Medica',
                'status' => 'active',
                'status_label' => 'Terpetakan KFA',
                'sync_status' => 'Tersinkron',
            ],
            [
                'id' => 'MED-004',
                'kfa_code' => '93004118',
                'name' => 'Metformin HCl 500 mg Tablet',
                'dose_form' => 'Tablet',
                'dose_form_code' => 'TAB',
                'strength' => '500 mg',
                'category' => 'Obat Keras (DM)',
                'category_tone' => 'red',
                'manufacturer' => 'PT Bernofarm',
                'status' => 'active',
                'status_label' => 'Terpetakan KFA',
                'sync_status' => 'Tersinkron',
            ],
            [
                'id' => 'MED-005',
                'kfa_code' => '93007892',
                'name' => 'Ceftriaxone 1 g Serbuk Injeksi Vial',
                'dose_form' => 'Injeksi / Vial',
                'dose_form_code' => 'VIAL',
                'strength' => '1 g',
                'category' => 'Antibiotik Keras',
                'category_tone' => 'red',
                'manufacturer' => 'PT Sanbe Farma',
                'status' => 'active',
                'status_label' => 'Terpetakan KFA',
                'sync_status' => 'Tersinkron',
            ],
            [
                'id' => 'MED-006',
                'kfa_code' => '93009021',
                'name' => 'Salbutamol 2 mg / 5 ml Sirup 100 ml',
                'dose_form' => 'Sirup (Oral Liquid)',
                'dose_form_code' => 'SYR',
                'strength' => '2 mg/5 ml',
                'category' => 'Obat Keras',
                'category_tone' => 'red',
                'manufacturer' => 'PT Pharos Indonesia',
                'status' => 'active',
                'status_label' => 'Terpetakan KFA',
                'sync_status' => 'Tersinkron',
            ],
            [
                'id' => 'MED-007',
                'kfa_code' => '93003445',
                'name' => 'Omeprazole 20 mg Kapsul Pelepasan Tunda',
                'dose_form' => 'Kapsul',
                'dose_form_code' => 'CAP',
                'strength' => '20 mg',
                'category' => 'Obat Keras',
                'category_tone' => 'red',
                'manufacturer' => 'PT Novell Pharma',
                'status' => 'active',
                'status_label' => 'Terpetakan KFA',
                'sync_status' => 'Tersinkron',
            ],
            [
                'id' => 'MED-008',
                'kfa_code' => '93006129',
                'name' => 'Oralit Serbuk untuk Larutan Oral 200 ml',
                'dose_form' => 'Serbuk Oral (Sachet)',
                'dose_form_code' => 'POWD',
                'strength' => '4.1 g/sachet',
                'category' => 'Obat Bebas',
                'category_tone' => 'green',
                'manufacturer' => 'PT Kimia Farma',
                'status' => 'active',
                'status_label' => 'Terpetakan KFA',
                'sync_status' => 'Tersinkron',
            ],
        ];

        return view('satusehat.medication', compact('summary', 'medications'));
    }
}

