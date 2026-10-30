<?php

namespace Database\Seeders;

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
        // Akun Admin — role: admin (all permissions)
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'              => 'Admin',
                'phone'             => '081234567890',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles('admin');

        // Akun User biasa — role: user (tanpa permission)
        $user = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name'              => 'User',
                'phone'             => '089876543210',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $user->syncRoles('user');

        $this->command->info('✓ Users berhasil di-seed.');
        $this->command->info('  admin@gmail.com  → role: admin');
        $this->command->info('  user@gmail.com   → role: user');
    }
}
