<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Daftar semua permission yang tersedia.
     */
    private array $permissions = [
        // Permission
        'permission.view',
        'permission.create',
        'permission.edit',
        'permission.delete',

        // Role
        'role.view',
        'role.create',
        'role.edit',
        'role.delete',

        // User
        'user.view',
        'user.create',
        'user.edit',
        'user.delete',
    ];

    public function run(): void
    {
        // Reset cached roles & permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Buat semua permissions
        foreach ($this->permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // 2. Buat role Admin — assign SEMUA permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        // 3. Buat role User — tanpa permission (bisa ditambah manual nanti)
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        $this->command->info('✓ Roles & Permissions berhasil di-seed.');
        $this->command->info('  Roles   : admin, user');
        $this->command->info('  Perms   : ' . implode(', ', $this->permissions));
    }
}

