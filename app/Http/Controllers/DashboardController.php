<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard (Today view) dengan data terstruktur.
     */
    public function index()
    {
        $clinic = [
            'name' => 'RSUD dr. Soebandi Jember',
            'sub' => 'Klinik Rawat Jalan & Poliklinik Terpadu',
            'doctor' => 'dr. Hendra Pratama, Sp.PD',
            'date_formatted' => now()->locale('id')->isoFormat('dddd, D MMMM Y'),
        ];

        $stats = [
            'total_appointments' => 28,
            'seen_count' => 16,
            'waiting_count' => 4,
            'avg_wait' => '12m',
            'avg_wait_tone' => 'good', // good | warn | bad
            'unread_wa' => 7,
            'avg_reply' => '3m',
            'no_show_rate' => '4.2%',
            'no_show_before' => '14.8%',
        ];

        $flow = [
            'upcoming' => [
                [
                    'id' => 'apt-01',
                    'patient_name' => 'Anisa Rahmawati',
                    'initial' => 'AR',
                    'color_tone' => 'teal',
                    'time' => '14:30',
                    'doctor' => 'dr. Siti Aminah, Sp.A',
                    'status' => 'confirmed',
                    'status_label' => 'Terkonfirmasi',
                    'action_label' => 'Check In',
                    'action_icon' => 'door',
                ],
                [
                    'id' => 'apt-02',
                    'patient_name' => 'Budi Santoso',
                    'initial' => 'BS',
                    'color_tone' => 'sky',
                    'time' => '15:00',
                    'doctor' => 'dr. Hendra, Sp.PD',
                    'status' => 'confirmed',
                    'status_label' => 'Terkonfirmasi',
                    'action_label' => 'Check In',
                    'action_icon' => 'door',
                ],
                [
                    'id' => 'apt-03',
                    'patient_name' => 'Dewi Lestari',
                    'initial' => 'DL',
                    'color_tone' => 'lilac',
                    'time' => '15:15',
                    'doctor' => 'dr. Bambang, Sp.JP',
                    'status' => 'unconfirmed',
                    'status_label' => 'Belum Konfirmasi',
                    'action_label' => 'Check In',
                    'action_icon' => 'door',
                ],
            ],
            'arrived' => [
                [
                    'id' => 'apt-04',
                    'patient_name' => 'Rahmat Hidayat',
                    'initial' => 'RH',
                    'color_tone' => 'apricot',
                    'time' => '13:45',
                    'doctor' => 'dr. Hendra, Sp.PD',
                    'wait_time' => '8m',
                    'is_long_wait' => false,
                    'action_label' => 'Panggil',
                    'action_icon' => 'stethoscope',
                ],
                [
                    'id' => 'apt-05',
                    'patient_name' => 'Siti Nurhaliza',
                    'initial' => 'SN',
                    'color_tone' => 'coral',
                    'time' => '13:30',
                    'doctor' => 'dr. Siti Aminah, Sp.A',
                    'wait_time' => '22m',
                    'is_long_wait' => true,
                    'action_label' => 'Panggil',
                    'action_icon' => 'stethoscope',
                ],
            ],
            'in_consult' => [
                [
                    'id' => 'apt-06',
                    'patient_name' => 'Ahmad Fauzi',
                    'initial' => 'AF',
                    'color_tone' => 'mint',
                    'time' => '13:50',
                    'doctor' => 'dr. Hendra, Sp.PD',
                    'room' => 'Poli Penyakit Dalam 1',
                    'progress' => '65%',
                    'action_label' => 'Selesai',
                    'action_icon' => 'check',
                ],
                [
                    'id' => 'apt-07',
                    'patient_name' => 'Ratna Sari Dewi',
                    'initial' => 'RS',
                    'color_tone' => 'sand',
                    'time' => '13:55',
                    'doctor' => 'dr. Bambang, Sp.JP',
                    'room' => 'Poli Jantung & Pembuluh',
                    'progress' => '40%',
                    'action_label' => 'Selesai',
                    'action_icon' => 'check',
                ],
            ],
            'done' => [
                [
                    'id' => 'apt-08',
                    'patient_name' => 'Slamet Riyadi',
                    'initial' => 'SR',
                    'color_tone' => 'teal',
                    'time' => '13:10',
                    'doctor' => 'dr. Hendra, Sp.PD',
                    'finished_at' => '13:42',
                ],
                [
                    'id' => 'apt-09',
                    'patient_name' => 'Sri Wahyuningsih',
                    'initial' => 'SW',
                    'color_tone' => 'sky',
                    'time' => '12:45',
                    'doctor' => 'dr. Siti Aminah, Sp.A',
                    'finished_at' => '13:15',
                ],
            ],
        ];

        $chats = [
            [
                'id' => 'c-101',
                'patient_id' => 'p-1',
                'patient_name' => 'Kusuma Wardani',
                'initial' => 'KW',
                'color' => 't1',
                'time' => '13:58',
                'snippet' => 'Selamat siang dokter, apakah hasil lab darah saya sudah keluar?',
                'unread' => 2,
                'urgent' => true,
            ],
            [
                'id' => 'c-102',
                'patient_id' => 'p-2',
                'patient_name' => 'Agus Priyono',
                'initial' => 'AP',
                'color' => 't2',
                'time' => '13:41',
                'snippet' => 'Saya mau konfirmasi jadwal kontrol hari Senin jam 09.00',
                'unread' => 1,
                'urgent' => false,
            ],
            [
                'id' => 'c-103',
                'patient_id' => 'p-3',
                'patient_name' => 'Hj. Endang Sulastri',
                'initial' => 'ES',
                'color' => 't3',
                'time' => '13:12',
                'snippet' => 'Terima kasih atas resep dan pelayanannya tadi dok.',
                'unread' => 0,
                'urgent' => false,
            ],
            [
                'id' => 'c-104',
                'patient_id' => 'p-4',
                'patient_name' => 'Dimas Prasetyo',
                'initial' => 'DP',
                'color' => 't0',
                'time' => '12:30',
                'snippet' => 'Obat penurun tensinya diminum sebelum atau sesudah makan?',
                'unread' => 0,
                'urgent' => false,
            ],
        ];

        $reminders = [
            'total' => 24,
            'tomorrow_count' => 24,
            'eligible_to_send' => 19,
            'sent' => 24,
            'sent_pct' => 100,
            'delivered' => 23,
            'delivered_pct' => 95,
            'read' => 20,
            'read_pct' => 83,
            'confirmed' => 18,
            'confirmed_pct' => 75,
            'reschedule_requests' => 2,
        ];

        $recalls = [
            [
                'id' => 'rec-01',
                'patient_id' => 'p-21',
                'patient_name' => 'H. Mochammad Toha',
                'initial' => 'MT',
                'color' => 't2',
                'condition' => 'Kontrol Hipertensi Rutin',
                'due_status' => 'Terlambat 3 hari',
                'is_overdue' => true,
            ],
            [
                'id' => 'rec-02',
                'patient_id' => 'p-22',
                'patient_name' => 'Nurul Hidayati',
                'initial' => 'NH',
                'color' => 't0',
                'condition' => 'Evaluasi HbA1c Diabetes Melitus',
                'due_status' => 'Jatuh tempo hari ini',
                'is_overdue' => false,
            ],
            [
                'id' => 'rec-03',
                'patient_id' => 'p-23',
                'patient_name' => 'Wayan Sudarta',
                'initial' => 'WS',
                'color' => 't1',
                'condition' => 'Pemeriksaan EKG Ulang',
                'due_status' => 'Jatuh tempo 4 hari lagi',
                'is_overdue' => false,
            ],
        ];

        $clinicians = [
            [
                'name' => 'dr. Hendra Pratama, Sp.PD',
                'short' => 'dr. Hendra',
                'initial' => 'HP',
                'color' => 't0',
                'status' => 'Sedang Konsultasi (Ahmad Fauzi)',
                'is_busy' => true,
                'booked_rate' => '85%',
                'util_scale' => '0.85',
                'next_info' => 'Berikutnya 14:30',
            ],
            [
                'name' => 'dr. Siti Aminah, Sp.A',
                'short' => 'dr. Siti',
                'initial' => 'SA',
                'color' => 't1',
                'status' => 'Tersedia',
                'is_busy' => false,
                'booked_rate' => '70%',
                'util_scale' => '0.70',
                'next_info' => 'Berikutnya 14:30',
            ],
            [
                'name' => 'dr. Bambang Sugiarto, Sp.JP',
                'short' => 'dr. Bambang',
                'initial' => 'BS',
                'color' => 't2',
                'status' => 'Sedang Konsultasi (Ratna Sari)',
                'is_busy' => true,
                'booked_rate' => '60%',
                'util_scale' => '0.60',
                'next_info' => 'Berikutnya 15:15',
            ],
        ];

        $activity = [
            [
                'id' => 'act-1',
                'type' => 'message',
                'icon' => 'whatsapp',
                'user' => 'dr. Hendra',
                'action' => 'mengirim pengingat obat ke',
                'target' => 'Kusuma Wardani',
                'time' => '6 menit lalu',
            ],
            [
                'id' => 'act-2',
                'type' => 'checkin',
                'icon' => 'door',
                'user' => 'Pendaftaran',
                'action' => 'mendaftarkan check-in pasien',
                'target' => 'Rahmat Hidayat',
                'time' => '15 menit lalu',
            ],
            [
                'id' => 'act-3',
                'type' => 'appointment',
                'icon' => 'calendar',
                'user' => 'dr. Siti Aminah',
                'action' => 'menyelesaikan konsultasi dengan',
                'target' => 'Sri Wahyuningsih',
                'time' => '45 menit lalu',
            ],
            [
                'id' => 'act-4',
                'type' => 'campaign',
                'icon' => 'megaphone',
                'user' => 'Admin SIMRS',
                'action' => 'menjadwalkan broadcast info vaksinasi',
                'target' => 'Poli Anak',
                'time' => '1 jam lalu',
            ],
        ];

        $satusehatLogs = \App\Models\SatusehatLog::orderBy('tanggal', 'desc')->get();
        $satusehatSummary = [
            'total_encounter' => $satusehatLogs->sum('encounter'),
            'total_diagnosa' => $satusehatLogs->sum('diagnosa'),
            'last_sync' => $satusehatLogs->first()?->tanggal?->format('d M Y') ?? date('d M Y'),
            'days_count' => $satusehatLogs->count(),
        ];

        return view('dashboard.index', compact(
            'clinic',
            'stats',
            'flow',
            'chats',
            'reminders',
            'recalls',
            'clinicians',
            'activity',
            'satusehatLogs',
            'satusehatSummary'
        ));
    }
}
