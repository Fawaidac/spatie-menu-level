<?php

namespace App\Services;

use App\Models\Location;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LocationService
{
    /**
     * Ambil semua lokasi aktif yang punya keterangan (sesuai native query)
     * dan return sebagai flat collection
     */
    public function getAllActiveLocations()
    {
        return Location::active()
            ->where('keterangan', '<>', '')
            ->whereNotNull('keterangan')
            ->orderBy('satu_sehat_id')
            ->get();
    }

    /**
     * Ambil data lokasi dengan paginasi dan filter pencarian
     */
    public function getPaginatedLocations(?string $cari = null, string $status = 'all', int $perPage = 15): LengthAwarePaginator
    {
        $query = Location::active()
            ->where('keterangan', '<>', '')
            ->whereNotNull('keterangan');

        if (!empty($cari)) {
            $query->where(function ($q) use ($cari) {
                $q->where('nama', 'LIKE', "%{$cari}%")
                  ->orWhere('kode', 'LIKE', "%{$cari}%")
                  ->orWhere('keterangan', 'LIKE', "%{$cari}%")
                  ->orWhere('satu_sehat_id', 'LIKE', "%{$cari}%");
            });
        }

        if ($status === 'active' || $status === 'synced') {
            $query->whereNotNull('satu_sehat_id')->where('satu_sehat_id', '<>', '');
        } elseif ($status === 'unmapped' || $status === 'pending') {
            $query->where(function ($q) {
                $q->whereNull('satu_sehat_id')->orWhere('satu_sehat_id', '');
            });
        }

        return $query->orderBy('nama', 'asc')->paginate($perPage)->withQueryString();
    }

    /**
     * Hitung summary stats
     */
    public function getSummary(): array
    {
        $total = Location::active()
            ->where('keterangan', '<>', '')
            ->whereNotNull('keterangan')
            ->count();

        $withSatuSehatId = Location::active()
            ->where('keterangan', '<>', '')
            ->whereNotNull('keterangan')
            ->whereNotNull('satu_sehat_id')
            ->where('satu_sehat_id', '<>', '')
            ->count();

        return [
            'total_location' => $total,
            'active_location' => $withSatuSehatId,
            'pending_location' => $total - $withSatuSehatId,
            'total_building' => $total,
            'last_sync' => now()->format('d M Y'),
        ];
    }
}
