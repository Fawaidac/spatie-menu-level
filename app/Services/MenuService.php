<?php

namespace App\Services;

use App\Models\Level;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MenuService
{
    public function create(array $data, ?Menu $parent = null): Menu
    {
        if ($parent && $parent->parent_id !== null) {
            throw ValidationException::withMessages([
                'parent_id' => 'Struktur menu dibatasi maksimal 2 tingkat (Menu Utama dan Sub-Menu).',
            ]);
        }

        return DB::transaction(function () use ($data, $parent) {
            if ($parent) {
                $parent->update(['url' => '#']); // punya anak, jadi url wajib '#'
                $parent->levels()->detach(); // parent jadi grup, hak aksesnya dibuang
            }

            $menu = Menu::create([
                'parent_id' => $parent?->id,
                'kode_menu' => $this->generateKode($parent),
                'nama' => $data['nama'],
                'url' => !empty($data['url']) ? $data['url'] : '#',
                'icon' => $data['icon'] ?? null,
                'urutan' => Menu::where('parent_id', $parent?->id)->max('urutan') + 1,
            ]);

            // Level admin otomatis dapat akses penuh ke menu baru
            if ($admin = Level::where('nama', 'admin')->first()) {
                $admin->menus()->syncWithoutDetaching([
                    $menu->id => [
                        'can_view' => true,
                        'can_add' => true,
                        'can_edit' => true,
                        'can_del' => true,
                    ],
                ]);
            }

            Level::forgetAccess();

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

        $menu->delete(); // baris level_menu ikut terhapus (cascade)
        Level::forgetAccess();
    }

    private function generateKode(?Menu $parent): string
    {
        if (!$parent) {
            $last = Menu::whereNull('parent_id')->orderByDesc('kode_menu')->value('kode_menu');
            return $last ? chr(ord($last) + 1) : 'A'; // A, B, C, ... (sampai Z)
        }

        $prefix = $parent->kode_menu;
        $n = $parent->children()->pluck('kode_menu')->map(fn($k) => (int) substr($k, strlen($prefix)))->max() + 1;

        while (Menu::where('kode_menu', $prefix . $n)->exists()) {
            $n++; // hindari bentrok, misalnya D1+1 dengan D11
        }

        return $prefix . $n;
    }
}
