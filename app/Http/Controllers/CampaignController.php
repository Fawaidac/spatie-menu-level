<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Tampilkan manajemen kampanye broadcast & template pesan WhatsApp resmi.
     */
    public function index()
    {
        $campaigns = [
            [
                'id' => 'cp-1',
                'name' => 'Pengingat Kontrol Rutin Hipertensi & Diabetes',
                'template_name' => 'pengingat_kontrol_bulanan',
                'status' => 'sending',
                'status_label' => 'Sedang Mengirim',
                'target_audience' => 'Pasien Poli Penyakit Dalam (30 hari terakhir)',
                'sent_at' => 'Hari ini, 13:00 WIB',
                'total_recipients' => 120,
                'stats' => [
                    'sent' => 120, 'sent_pct' => 100,
                    'delivered' => 114, 'delivered_pct' => 95,
                    'read' => 98, 'read_pct' => 82,
                    'replied' => 42, 'replied_pct' => 35,
                ],
                'snippet' => 'Yth. {{1}}, kami menginfokan jadwal kontrol rutin Anda di RSUD dr. Soebandi jatuh tempo pada tanggal {{2}}.',
            ],
            [
                'id' => 'cp-2',
                'name' => 'Sosialisasi Vaksinasi PCV & Influenza Anak',
                'template_name' => 'edukasi_imunisasi_anak',
                'status' => 'sent',
                'status_label' => 'Terkirim Selesai',
                'target_audience' => 'Orang Tua Pasien Poli Anak (Usia < 5 th)',
                'sent_at' => 'Kemarin, 09:30 WIB',
                'total_recipients' => 85,
                'stats' => [
                    'sent' => 85, 'sent_pct' => 100,
                    'delivered' => 85, 'delivered_pct' => 100,
                    'read' => 76, 'read_pct' => 89,
                    'replied' => 28, 'replied_pct' => 33,
                ],
                'snippet' => 'Halo Bunda/Ayah {{1}}, lindungi ananda dengan imunisasi PCV lengkap di Poliklinik Tumbuh Kembang RSUD dr. Soebandi.',
            ],
            [
                'id' => 'cp-3',
                'name' => 'Pengumuman Jadwal Poliklinik Hari Libur Nasional',
                'template_name' => 'info_layanan_libur',
                'status' => 'scheduled',
                'status_label' => 'Terjadwal',
                'target_audience' => 'Seluruh Pasien Rawat Jalan Aktif',
                'sent_at' => 'Besok, 08:00 WIB',
                'total_recipients' => 450,
                'stats' => [
                    'sent' => 0, 'sent_pct' => 0,
                    'delivered' => 0, 'delivered_pct' => 0,
                    'read' => 0, 'read_pct' => 0,
                    'replied' => 0, 'replied_pct' => 0,
                ],
                'snippet' => 'Pemberitahuan: Selama libur nasional, pelayanan IGD & Rawat Inap tetap siaga 24 jam. Poliklinik buka kembali pada hari kerja.',
            ],
        ];

        $templates = [
            [
                'name' => 'konfirmasi_janji_pasien',
                'category' => 'utility',
                'category_label' => 'Utility / Layanan',
                'status' => 'approved',
                'status_label' => 'Disetujui Meta',
                'body' => 'Halo {{1}}, janji temu Anda di RSUD dr. Soebandi untuk {{2}} telah dikonfirmasi pada {{3}}. Mohon hadir 15 menit lebih awal.',
            ],
            [
                'name' => 'hasil_lab_selesai',
                'category' => 'utility',
                'category_label' => 'Utility / Layanan',
                'status' => 'approved',
                'status_label' => 'Disetujui Meta',
                'body' => 'Bpk/Ibu {{1}}, hasil pemeriksaan laboratorium No. Lab {{2}} telah selesai dan dapat diunduh melalui link berikut: {{3}}.',
            ],
            [
                'name' => 'pengingat_minum_obat',
                'category' => 'marketing',
                'category_label' => 'Informasi & Edukasi',
                'status' => 'approved',
                'status_label' => 'Disetujui Meta',
                'body' => 'Halo {{1}}, jangan lupa minum obat {{2}} sesuai anjuran dokter Anda demi kestabilan tekanan darah dan kesehatan Anda.',
            ],
        ];

        return view('campaigns.index', compact('campaigns', 'templates'));
    }
}
