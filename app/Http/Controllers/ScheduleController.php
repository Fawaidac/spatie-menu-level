<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Tampilkan antarmuka jadwal dan kalender poliklinik terpadu.
     */
    public function index()
    {
        $clinicians = [
            [
                'id' => 'doc-1',
                'name' => 'dr. Hendra Pratama, Sp.PD',
                'short' => 'dr. Hendra',
                'specialty' => 'Spesialis Penyakit Dalam',
                'room' => 'Poli Penyakit Dalam 1',
                'initial' => 'HP',
                'color' => 'teal',
                'active' => true,
                'load' => '85%',
                'booked' => 14,
                'slots' => [
                    ['start' => '08:30', 'mins' => 30, 'top' => '62px', 'height' => '60px', 'name' => 'Slamet Riyadi', 'type' => 'Kontrol Rutin', 'status' => 'done'],
                    ['start' => '10:00', 'mins' => 45, 'top' => '248px', 'height' => '90px', 'name' => 'Sri Wahyuningsih', 'type' => 'Konsultasi Lab', 'status' => 'done'],
                    ['start' => '13:50', 'mins' => 30, 'top' => '720px', 'height' => '60px', 'name' => 'Ahmad Fauzi', 'type' => 'Rawat Jalan', 'status' => 'in-consult'],
                    ['start' => '15:00', 'mins' => 30, 'top' => '868px', 'height' => '60px', 'name' => 'Budi Santoso', 'type' => 'Pemeriksaan Lanjutan', 'status' => 'arrived'],
                ]
            ],
            [
                'id' => 'doc-2',
                'name' => 'dr. Siti Aminah, Sp.A',
                'short' => 'dr. Siti',
                'specialty' => 'Spesialis Anak',
                'room' => 'Poliklinik Anak',
                'initial' => 'SA',
                'color' => 'lilac',
                'active' => true,
                'load' => '70%',
                'booked' => 10,
                'slots' => [
                    ['start' => '09:00', 'mins' => 45, 'top' => '124px', 'height' => '90px', 'name' => 'Rian Ananda', 'type' => 'Tumbuh Kembang', 'status' => 'done'],
                    ['start' => '13:30', 'mins' => 30, 'top' => '680px', 'height' => '60px', 'name' => 'Siti Nurhaliza', 'type' => 'Evaluasi Pengobatan', 'status' => 'arrived'],
                    ['start' => '14:30', 'mins' => 30, 'top' => '806px', 'height' => '60px', 'name' => 'Anisa Rahmawati', 'type' => 'Vaksinasi DPT', 'status' => 'arrived'],
                ]
            ],
            [
                'id' => 'doc-3',
                'name' => 'dr. Bambang Sugiarto, Sp.JP',
                'short' => 'dr. Bambang',
                'specialty' => 'Spesialis Jantung & Pembuluh',
                'room' => 'Poli Jantung Terpadu',
                'initial' => 'BS',
                'color' => 'mint',
                'active' => true,
                'load' => '60%',
                'booked' => 8,
                'slots' => [
                    ['start' => '09:30', 'mins' => 60, 'top' => '186px', 'height' => '120px', 'name' => 'Supriyadi', 'type' => 'Pemeriksaan EKG & Echo', 'status' => 'done'],
                    ['start' => '13:55', 'mins' => 45, 'top' => '735px', 'height' => '90px', 'name' => 'Ratna Sari Dewi', 'type' => 'Konsultasi Hipertensi', 'status' => 'in-consult'],
                    ['start' => '15:15', 'mins' => 30, 'top' => '900px', 'height' => '60px', 'name' => 'Dewi Lestari', 'type' => 'Evaluasi Obat Jantung', 'status' => 'arrived'],
                ]
            ],
        ];

        $currentDate = now()->locale('id')->isoFormat('dddd, D MMMM Y');

        return view('schedule.index', compact('clinicians', 'currentDate'));
    }
}
