<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MenuService
{
    public function create(array $data, ?Menu $parent = null): Menu
    {
        if ($parent && $parent->parent_id != 0 && $parent->parent_id !== null) {
            throw ValidationException::withMessages([
                'parent_id' => 'Struktur menu dibatasi maksimal 2 tingkat (Menu Utama dan Sub-Menu).',
            ]);
        }

        return DB::connection('mysql')->transaction(function () use ($data, $parent) {
            if ($parent) {
                $parent->update(['url' => '#']); // punya anak, jadi url '#'
            }

            $parentId = $parent ? $parent->id : 0;
            $levelDepth = $parent ? 1 : 0;
            $kodeMenu = $this->generateKode($parent);

            $menu = Menu::create([
                'parent_id' => $parentId,
                'kdmenu'    => $kodeMenu,
                'nmmenu'    => $data['nama'],
                'url'       => ! empty($data['url']) ? $data['url'] : '#',
                'icon'      => $data['icon'] ?? null,
                'level'     => $levelDepth,
                'aktif'     => '1',
            ]);

            // Level Superuser otomatis dapat hak akses penuh ke menu baru
            $acts = [1, 2, 3, 4]; // view, add, edit, del
            $perms = [];
            foreach ($acts as $act) {
                $perms[] = [
                    'nama_level' => 'Superuser',
                    'id_menu'    => $menu->id,
                    'act'        => $act,
                ];
            }
            DB::connection('mysql')->table('ms_level')->insert($perms);

            Cache::flush();

            return $menu;
        });
    }

    public function delete(Menu $menu): void
    {
        if ($menu->children()->exists()) {
            throw ValidationException::withMessages([
                'menu' => 'Menu masih memiliki sub menu, tidak bisa dihapus.',
            ]);
        }

        DB::connection('mysql')->transaction(function () use ($menu) {
            // Hapus hak akses terkait di ms_level
            DB::connection('mysql')->table('ms_level')->where('id_menu', $menu->id)->delete();
            $menu->delete();
        });

        Cache::flush();
    }

    private function generateKode(?Menu $parent): string
    {
        if (! $parent) {
            $last = Menu::where(function ($q) {
                $q->whereNull('parent_id')->orWhere('parent_id', 0);
            })->orderByDesc('kdmenu')->value('kdmenu');

            return $last ? chr(ord($last) + 1) : 'A';
        }

        $prefix = $parent->kdmenu;
        $maxNum = $parent->children()
            ->pluck('kdmenu')
            ->map(fn ($k) => (int) substr($k, strlen($prefix)))
            ->max();

        $n = ($maxNum ?? 0) + 1;

        while (Menu::where('kdmenu', $prefix . $n)->exists()) {
            $n++;
        }

        return $prefix . $n;
    }
}
