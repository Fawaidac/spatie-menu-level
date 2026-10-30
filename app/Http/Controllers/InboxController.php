<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InboxController extends Controller
{
    /**
     * Tampilkan antarmuka WhatsApp Inbox 3-Panel lengkap.
     */
    public function index()
    {
        $stats = [
            'unread' => 7,
            'waiting' => 4,
            'avg_reply' => '3m',
        ];

        $threads = [
            [
                'id' => 'th-01',
                'patient_id' => 'p-01',
                'patient_name' => 'Kusuma Wardani',
                'initial' => 'KW',
                'color' => 't1',
                'time' => '13:58',
                'snippet' => 'Selamat siang dokter, apakah hasil lab darah saya sudah keluar?',
                'unread' => 2,
                'urgent' => true,
                'is_active' => true,
                'tag' => 'Lab & Hasil',
            ],
            [
                'id' => 'th-02',
                'patient_id' => 'p-02',
                'patient_name' => 'Agus Priyono',
                'initial' => 'AP',
                'color' => 't2',
                'time' => '13:41',
                'snippet' => 'Saya mau konfirmasi jadwal kontrol hari Senin jam 09.00',
                'unread' => 1,
                'urgent' => false,
                'is_active' => false,
                'tag' => 'Jadwal Kontrol',
            ],
            [
                'id' => 'th-03',
                'patient_id' => 'p-03',
                'patient_name' => 'Hj. Endang Sulastri',
                'initial' => 'ES',
                'color' => 't3',
                'time' => '13:12',
                'snippet' => 'Terima kasih atas resep dan pelayanannya tadi dok.',
                'unread' => 0,
                'urgent' => false,
                'is_active' => false,
                'tag' => 'Konsultasi Selesai',
            ],
            [
                'id' => 'th-04',
                'patient_id' => 'p-04',
                'patient_name' => 'Dimas Prasetyo',
                'initial' => 'DP',
                'color' => 't0',
                'time' => '12:30',
                'snippet' => 'Obat penurun tensinya diminum sebelum atau sesudah makan?',
                'unread' => 0,
                'urgent' => false,
                'is_active' => false,
                'tag' => 'Farmasi',
            ],
            [
                'id' => 'th-05',
                'patient_id' => 'p-05',
                'patient_name' => 'Bambang Trihatmojo',
                'initial' => 'BT',
                'color' => 't4',
                'time' => '11:15',
                'snippet' => 'Apakah poli spesialis jantung buka di hari Sabtu?',
                'unread' => 0,
                'urgent' => false,
                'is_active' => false,
                'tag' => 'Informasi Poliklinik',
            ],
        ];

        $activeThread = [
            'id' => 'th-01',
            'patient' => [
                'name' => 'Kusuma Wardani',
                'rm_no' => 'RM-2024-0891',
                'nik' => '3509195802860002',
                'phone' => '+62 812-3456-7890',
                'age' => '38 tahun',
                'gender' => 'Perempuan',
                'tags' => ['Penyakit Dalam', 'Hipertensi Primer', 'BPJS Kesehatan'],
                'allergies' => ['Penisilin', 'Aspirin'],
                'consent' => 'Terdaftar & Izin Aktif',
                'assigned_doctor' => 'dr. Hendra Pratama, Sp.PD',
            ],
            'next_appointment' => [
                'date' => 'Senin, 3 Nov 2026',
                'time' => '09:30 WIB',
                'poli' => 'Poli Penyakit Dalam 1',
                'doctor' => 'dr. Hendra Pratama, Sp.PD',
            ],
            'messages' => [
                [
                    'dir' => 'in',
                    'time' => '13:40',
                    'text' => 'Halo RSUD dr. Soebandi, saya pasien dr. Hendra yang tadi pagi ambil darah.',
                ],
                [
                    'dir' => 'out',
                    'time' => '13:42',
                    'text' => 'Selamat siang Ibu Kusuma. Terima kasih telah menghubungi kami. Baik, kami bantu koordinasikan dengan bagian Laboratorium Patologi Klinik ya.',
                    'status' => 'read',
                ],
                [
                    'dir' => 'in',
                    'time' => '13:58',
                    'text' => 'Selamat siang dokter, apakah hasil lab darah saya sudah keluar? Soalnya mau saya bawa untuk konsultasi lanjutan.',
                ],
            ],
        ];

        return view('inbox.index', compact('stats', 'threads', 'activeThread'));
    }
}
