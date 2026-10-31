<?php

namespace App\Http\Controllers\Satusehat;

use Illuminate\Http\Request;

class PatientController extends \App\Http\Controllers\Controller
{
    /**
     * Tampilkan daftar pasien RSUD dengan filter & tabel terstruktur.
     */
    public function index()
    {
        $stats = [
            'total' => 1428,
            'active_filter' => 'semua',
        ];

        $categories = [
            ['id' => 'all', 'label' => 'Semua Pasien', 'count' => 1428, 'tone' => 'faint', 'active' => true],
            ['id' => 'new', 'label' => 'Pasien Baru', 'count' => 142, 'tone' => 'sky', 'active' => false],
            ['id' => 'chronic', 'label' => 'Penyakit Kronis', 'count' => 380, 'tone' => 'lilac', 'active' => false],
            ['id' => 'pregnancy', 'label' => 'Ibu Hamil / Obgyn', 'count' => 85, 'tone' => 'coral', 'active' => false],
            ['id' => 'pediatric', 'label' => 'Pediatrik / Anak', 'count' => 210, 'tone' => 'apricot', 'active' => false],
            ['id' => 'senior', 'label' => 'Geriatri / Lansia', 'count' => 412, 'tone' => 'sand', 'active' => false],
            ['id' => 'vip', 'label' => 'Pasien Prioritas', 'count' => 64, 'tone' => 'teal', 'active' => false],
        ];

        $patients = [
            [
                'id' => 'p-001',
                'rm_no' => 'RM-2024-001',
                'name' => 'Anisa Rahmawati',
                'initial' => 'AR',
                'color' => 'teal',
                'age' => '29 th',
                'gender' => 'P',
                'phone' => '+62 812-9876-5432',
                'consent' => 'opted-in',
                'consent_label' => 'WA Terhubung',
                'next_appt' => 'Hari ini, 14:30',
                'next_status' => 'confirmed',
                'last_visit' => '12 Okt 2026',
                'doctor' => 'dr. Siti Aminah, Sp.A',
                'tags' => ['Poli Anak', 'Vaksinasi'],
            ],
            [
                'id' => 'p-002',
                'rm_no' => 'RM-2024-002',
                'name' => 'Budi Santoso',
                'initial' => 'BS',
                'color' => 'sky',
                'age' => '45 th',
                'gender' => 'L',
                'phone' => '+62 813-1122-3344',
                'consent' => 'opted-in',
                'consent_label' => 'WA Terhubung',
                'next_appt' => 'Hari ini, 15:00',
                'next_status' => 'confirmed',
                'last_visit' => '5 Sep 2026',
                'doctor' => 'dr. Hendra Pratama, Sp.PD',
                'tags' => ['Penyakit Dalam', 'Hipertensi'],
            ],
            [
                'id' => 'p-003',
                'rm_no' => 'RM-2024-003',
                'name' => 'Dewi Lestari',
                'initial' => 'DL',
                'color' => 'lilac',
                'age' => '34 th',
                'gender' => 'P',
                'phone' => '+62 815-5544-3322',
                'consent' => 'pending',
                'consent_label' => 'Menunggu Izin',
                'next_appt' => 'Hari ini, 15:15',
                'next_status' => 'booked',
                'last_visit' => '20 Ags 2026',
                'doctor' => 'dr. Bambang Sugiarto, Sp.JP',
                'tags' => ['Poli Jantung'],
            ],
            [
                'id' => 'p-004',
                'rm_no' => 'RM-2024-004',
                'name' => 'Rahmat Hidayat',
                'initial' => 'RH',
                'color' => 'apricot',
                'age' => '52 th',
                'gender' => 'L',
                'phone' => '+62 817-8899-0011',
                'consent' => 'opted-in',
                'consent_label' => 'WA Terhubung',
                'next_appt' => 'Di Ruang Tunggu',
                'next_status' => 'arrived',
                'last_visit' => '14 Okt 2026',
                'doctor' => 'dr. Hendra Pratama, Sp.PD',
                'tags' => ['Diabetes Melitus', 'Geriatri'],
            ],
            [
                'id' => 'p-005',
                'rm_no' => 'RM-2024-005',
                'name' => 'Siti Nurhaliza',
                'initial' => 'SN',
                'color' => 'coral',
                'age' => '6 th',
                'gender' => 'P',
                'phone' => '+62 819-2233-4455',
                'consent' => 'opted-in',
                'consent_label' => 'WA Terhubung',
                'next_appt' => 'Di Ruang Tunggu',
                'next_status' => 'arrived',
                'last_visit' => '30 Jul 2026',
                'doctor' => 'dr. Siti Aminah, Sp.A',
                'tags' => ['Pediatrik', 'Alergi Dingin'],
            ],
            [
                'id' => 'p-006',
                'rm_no' => 'RM-2024-006',
                'name' => 'H. Mochammad Toha',
                'initial' => 'MT',
                'color' => 'sand',
                'age' => '68 th',
                'gender' => 'L',
                'phone' => '+62 812-7788-9900',
                'consent' => 'opted-in',
                'consent_label' => 'WA Terhubung',
                'next_appt' => 'Jatuh Tempo Kontrol',
                'next_status' => 'no-show',
                'last_visit' => '15 Sep 2026',
                'doctor' => 'dr. Hendra Pratama, Sp.PD',
                'tags' => ['Geriatri', 'Kontrol Rutin'],
            ],
        ];

        return view('satusehat.patient.index', compact('stats', 'categories', 'patients'));
    }

    public function create() { return view('patients.create'); }
    public function store(Request $request) { return redirect()->route('patients.index'); }
    public function show(string $id) { return view('patients.show', compact('id')); }
    public function edit(string $id) { return view('patients.edit', compact('id')); }
    public function update(Request $request, string $id) { return redirect()->route('patients.index'); }
    public function destroy(string $id) { return redirect()->route('patients.index'); }
}
