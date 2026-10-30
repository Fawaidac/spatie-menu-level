<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\User;
use App\Services\MenuService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccessSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Level::firstOrCreate(['nama' => 'admin'], ['is_system' => true]);
        Level::firstOrCreate(['nama' => 'user'], ['is_system' => true]);

        $tree = [
            ['nama' => 'Dashboard', 'url' => 'dashboard', 'icon' => 'home'],
            [
                'nama' => 'Setting',
                'icon' => 'cog',
                'children' => [
                    // B
                    ['nama' => 'Menu', 'url' => 'setting/menu'], // B1
                    ['nama' => 'Level', 'url' => 'setting/level'], // B2
                    ['nama' => 'User', 'url' => 'setting/user'], // B3
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

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'level_id' => $admin->id,
            ],
        );

        $this->command->info('Seed selesai. Login: admin@example.com / password');
    }
}
