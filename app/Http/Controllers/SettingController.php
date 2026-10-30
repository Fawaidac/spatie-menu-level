<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan SIMRS & WhatsApp Gateway.
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'clinic');

        $clinic = [
            'name' => 'RSUD dr. Soebandi Jember',
            'type' => 'Rumah Sakit Umum Daerah Kelas B Pendidikan',
            'address' => 'Jl. Dr. Soebandi No.124, Patrang, Jember, Jawa Timur 68111',
            'phone' => '(0331) 487441',
            'email' => 'rsud_soebandi@jemberkab.go.id',
            'website' => 'https://rsuddrsoebandi.jemberkab.go.id',
        ];

        $whatsapp = [
            'status' => 'online',
            'status_label' => 'Terhubung Aktif',
            'display_name' => 'RSUD dr. Soebandi Official',
            'phone_number' => '+62 811-3000-888',
            'waba_id' => 'WABA_109847291847192',
            'phone_number_id' => 'PNID_5839201948201',
            'quality_rating' => 'Tinggi / Green',
            'messaging_limit' => '100.000 pesan / 24 jam (Tier 3)',
            'webhook_url' => 'https://simrs.rsudsoebandi.id/api/whatsapp/webhook',
        ];

        $hours = [
            ['day' => 'Senin', 'open' => '07:30', 'close' => '15:30', 'is_open' => true],
            ['day' => 'Selasa', 'open' => '07:30', 'close' => '15:30', 'is_open' => true],
            ['day' => 'Rabu', 'open' => '07:30', 'close' => '15:30', 'is_open' => true],
            ['day' => 'Kamis', 'open' => '07:30', 'close' => '15:30', 'is_open' => true],
            ['day' => 'Jumat', 'open' => '07:00', 'close' => '14:30', 'is_open' => true],
            ['day' => 'Sabtu', 'open' => '07:30', 'close' => '12:00', 'is_open' => true],
            ['day' => 'Minggu', 'open' => '-', 'close' => '-', 'is_open' => false],
        ];

        $team = [
            ['name' => 'dr. Hendra Pratama, Sp.PD', 'role' => 'Dokter Spesialis', 'unit' => 'Poli Penyakit Dalam', 'phone' => '+62 812-3456-7890'],
            ['name' => 'dr. Siti Aminah, Sp.A', 'role' => 'Dokter Spesialis', 'unit' => 'Poliklinik Anak', 'phone' => '+62 813-9876-5432'],
            ['name' => 'dr. Bambang Sugiarto, Sp.JP', 'role' => 'Dokter Spesialis', 'unit' => 'Poli Jantung & Pembuluh', 'phone' => '+62 815-1122-3344'],
            ['name' => 'Ns. Ratna Wulandari, S.Kep', 'role' => 'Kepala Ruang Rawat Jalan', 'unit' => 'Keperawatan Poliklinik', 'phone' => '+62 818-4455-6677'],
        ];

        return view('settings.index', compact('tab', 'clinic', 'whatsapp', 'hours', 'team'));
    }

    public function whatsapp()
    {
        return redirect()->route('settings.index', ['tab' => 'whatsapp']);
    }

    public function update(Request $request)
    {
        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
