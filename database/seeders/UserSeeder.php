<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminLevel = Level::firstOrCreate(['nama' => 'admin'], ['is_system' => true]);
        $userLevel  = Level::firstOrCreate(['nama' => 'user'], ['is_system' => true]);

        // Akun Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'              => 'Admin',
                'phone'             => '081234567890',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'level_id'          => $adminLevel->id,
            ]
        );
        if (!$admin->level_id) {
            $admin->update(['level_id' => $adminLevel->id]);
        }

        // Akun User biasa
        $user = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name'              => 'User',
                'phone'             => '089876543210',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'level_id'          => $userLevel->id,
            ]
        );
        if (!$user->level_id) {
            $user->update(['level_id' => $userLevel->id]);
        }

        $this->command->info('✓ Users berhasil di-seed.');
        $this->command->info('  admin@gmail.com / password (Level: admin)');
        $this->command->info('  user@gmail.com  / password (Level: user)');
    }
}
