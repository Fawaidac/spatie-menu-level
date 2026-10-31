<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\Menu;
use App\Models\User;
use App\Services\MenuService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AccessSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('level_menu')->truncate();
        DB::table('menus')->truncate();
        Schema::enableForeignKeyConstraints();

        $admin = Level::firstOrCreate(['nama' => 'admin'], ['is_system' => true]);
        $userLevel = Level::firstOrCreate(['nama' => 'user'], ['is_system' => true]);

        $tree = [
            ['nama' => 'Dashboard', 'url' => 'dashboard', 'icon' => 'home'],
            ['nama' => 'Pasien', 'url' => 'patients', 'icon' => 'users'],
            ['nama' => 'Jadwal', 'url' => 'schedule', 'icon' => 'calendar'],
            ['nama' => 'Pesan Masuk', 'url' => 'inbox', 'icon' => 'inbox'],
            ['nama' => 'Kampanye', 'url' => 'campaigns', 'icon' => 'megaphone'],
            ['nama' => 'Laporan', 'url' => 'reports', 'icon' => 'chart'],
            [
                'nama' => 'Pengaturan & Akses',
                'icon' => 'cog',
                'url' => '#',
                'children' => [
                    ['nama' => 'Menu', 'url' => 'setting/menu', 'icon' => 'menu'],
                    ['nama' => 'Level', 'url' => 'setting/level', 'icon' => 'shield'],
                    ['nama' => 'User', 'url' => 'setting/user', 'icon' => 'user'],
                    ['nama' => 'Klinik & WhatsApp', 'url' => 'settings', 'icon' => 'gear'],
                ],
            ],
        ];

        $service = app(MenuService::class);
        $insert = function (array $items, $parent = null) use (&$insert, $service) {
            foreach ($items as $item) {
                $menu = $service->create($item, $parent);
                if (!empty($item['children'])) {
                    $insert($item['children'], $menu);
                }
            }
        };
        $insert($tree);

        // Update default admin user
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin RSUD Soebandi',
                'phone' => '081234567890',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'level_id' => $admin->id,
            ],
        );

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'level_id' => $admin->id,
            ],
        );

        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Staf User',
                'phone' => '089876543210',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'level_id' => $userLevel->id,
            ],
        );

        Level::forgetAccess();

        $this->command->info('✓ AccessSeeder selesai.');
        $this->command->info('  admin@gmail.com (Level: admin)');
        $this->command->info('  user@gmail.com (Level: user)');
    }
}
