<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Tampilkan laporan statistik poliklinik & efektivitas WhatsApp.
     */
    public function index()
    {
        $metrics = [
            'period' => '30 Hari Terakhir',
            'no_show_before' => '14.8%',
            'no_show_after' => '4.2%',
            'no_show_drop' => '71%',
            'total_seen' => 1428,
            'wa_reminders_sent' => 1240,
            'wa_confirmed' => 942,
            'response_rate' => '76%',
        ];

        $funnel = [
            ['stage' => 'Terkirim', 'count' => 1240, 'pct' => 100, 'tone' => 'teal'],
            ['stage' => 'Diterima', 'count' => 1215, 'pct' => 98, 'tone' => 'sky'],
            ['stage' => 'Dibaca', 'count' => 1041, 'pct' => 84, 'tone' => 'tick'],
            ['stage' => 'Dikonfirmasi Pasien', 'count' => 942, 'pct' => 76, 'tone' => 'wa'],
        ];

        $patientMix = [
            ['name' => 'Poli Penyakit Dalam', 'pct' => '35%', 'count' => 500, 'tone' => 'teal'],
            ['name' => 'Poliklinik Anak', 'pct' => '25%', 'count' => 357, 'tone' => 'lilac'],
            ['name' => 'Poli Jantung & Pembuluh', 'pct' => '20%', 'count' => 285, 'tone' => 'mint'],
            ['name' => 'Poli Bedah Umum', 'pct' => '12%', 'count' => 171, 'tone' => 'coral'],
            ['name' => 'Poli Mata & THT', 'pct' => '8%', 'count' => 115, 'tone' => 'sand'],
        ];

        $clinicians = [
            ['name' => 'dr. Hendra Pratama, Sp.PD', 'short' => 'dr. Hendra', 'seen' => 482, 'cap' => '88%', 'ns' => '3.8%', 'tone' => 'good'],
            ['name' => 'dr. Siti Aminah, Sp.A', 'short' => 'dr. Siti', 'seen' => 350, 'cap' => '76%', 'ns' => '4.1%', 'tone' => 'good'],
            ['name' => 'dr. Bambang Sugiarto, Sp.JP', 'short' => 'dr. Bambang', 'seen' => 280, 'cap' => '65%', 'ns' => '4.5%', 'tone' => 'good'],
            ['name' => 'dr. Arif Wicaksono, Sp.B', 'short' => 'dr. Arif', 'seen' => 180, 'cap' => '54%', 'ns' => '5.2%', 'tone' => 'good'],
        ];

        return view('reports.index', compact('metrics', 'funnel', 'patientMix', 'clinicians'));
    }
}
