<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ManagementAclTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
    }

    public function test_admin_can_view_management_users_page(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('management.users.index'));
        $response->assertStatus(200);

        $admin->delete();
    }

    public function test_admin_can_create_and_update_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $email = 'dokter.' . uniqid() . '@tend.clinic';

        $response = $this->actingAs($admin)->post(route('management.users.store'), [
            'name'        => 'Dokter Baru',
            'email'       => $email,
            'phone'       => '081299998888',
            'role'        => 'user',
            'password'    => 'password123',
            'permissions' => ['user.view'],
        ]);

        $response->assertRedirect(route('management.users.index') . '#/users');
        $this->assertDatabaseHas('users', ['email' => $email]);
        $newUser = User::where('email', $email)->first();
        $this->assertTrue($newUser->hasRole('user'));
        $this->assertTrue($newUser->hasDirectPermission('user.view'));

        // Update user: unassign direct permission, change role to admin
        $response2 = $this->actingAs($admin)->put(route('management.users.update', $newUser), [
            'name'        => 'Dokter Diperbarui',
            'email'       => $email,
            'phone'       => '081299998888',
            'role'        => 'admin',
            'permissions' => [], // unassign direct permissions
        ]);

        $response2->assertRedirect(route('management.users.index') . '#/users');
        $newUser->refresh();
        $this->assertTrue($newUser->hasRole('admin'));
        $this->assertFalse($newUser->hasDirectPermission('user.view'));

        $newUser->delete();
        $admin->delete();
    }

    public function test_admin_can_create_and_delete_custom_role(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $roleName = 'apoteker_' . uniqid();

        // Create custom role with permissions assigned
        $response = $this->actingAs($admin)->post(route('management.roles.store'), [
            'name'        => $roleName,
            'permissions' => ['user.view', 'role.view'],
        ]);
        $response->assertRedirect(route('management.roles.index') . '#/roles');
        $this->assertDatabaseHas('roles', ['name' => $roleName]);
        $role = Role::where('name', $roleName)->first();
        $this->assertTrue($role->hasPermissionTo('user.view'));

        // Update role: unassign user.view, assign user.create
        $response2 = $this->actingAs($admin)->put(route('management.roles.update', $role), [
            'name'        => $roleName,
            'permissions' => ['user.create'],
        ]);
        $response2->assertRedirect(route('management.roles.index') . '#/roles');
        $role->refresh();
        $this->assertFalse($role->hasPermissionTo('user.view'));
        $this->assertTrue($role->hasPermissionTo('user.create'));

        // Delete custom role
        $response3 = $this->actingAs($admin)->delete(route('management.roles.destroy', $role));
        $response3->assertRedirect(route('management.roles.index') . '#/roles');
        $this->assertDatabaseMissing('roles', ['name' => $roleName]);

        $admin->delete();
    }

    public function test_system_role_cannot_be_deleted(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $adminRole = Role::where('name', 'admin')->first();
        $response = $this->actingAs($admin)->delete(route('management.roles.destroy', $adminRole));
        $this->assertDatabaseHas('roles', ['name' => 'admin']);

        $admin->delete();
    }

    public function test_admin_can_crud_permission(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $permName = 'test.perm.' . uniqid();

        // 1. Create permission
        $response = $this->actingAs($admin)->post(route('management.permissions.store'), [
            'name' => $permName,
        ]);
        $response->assertRedirect(route('management.role-permissions.index') . '#/role-permissions');
        $this->assertDatabaseHas('permissions', ['name' => $permName]);

        $perm = Permission::where('name', $permName)->first();

        // 2. Edit permission
        $updatedName = $permName . '.v2';
        $response2 = $this->actingAs($admin)->put(route('management.permissions.update', $perm), [
            'name' => $updatedName,
        ]);
        $response2->assertRedirect(route('management.role-permissions.index') . '#/role-permissions');
        $this->assertDatabaseHas('permissions', ['name' => $updatedName]);

        // 3. Delete permission
        $perm->refresh();
        $response3 = $this->actingAs($admin)->delete(route('management.permissions.destroy', $perm));
        $response3->assertRedirect(route('management.role-permissions.index') . '#/role-permissions');
        $this->assertDatabaseMissing('permissions', ['name' => $updatedName]);

        $admin->delete();
    }

    public function test_admin_can_sync_permissions_in_matrix(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $perm = Permission::firstOrCreate(['name' => 'test.matrix.perm', 'guard_name' => 'web']);
        $userRole = Role::where('name', 'user')->first();

        $response = $this->actingAs($admin)->post(route('management.role-permissions.update'), [
            'role_id'     => $userRole->id,
            'permissions' => [$perm->id],
        ]);

        $response->assertRedirect(route('management.role-permissions.index') . '#/role-permissions');
        $this->assertTrue($userRole->hasPermissionTo('test.matrix.perm'));

        // Unassign all permissions from userRole
        $response2 = $this->actingAs($admin)->post(route('management.role-permissions.update'), [
            'role_id'     => $userRole->id,
            'permissions' => [],
        ]);
        $response2->assertRedirect(route('management.role-permissions.index') . '#/role-permissions');
        $userRole->refresh();
        $this->assertFalse($userRole->hasPermissionTo('test.matrix.perm'));

        $perm->delete();
        $admin->delete();
    }

    public function test_register_assigns_default_user_role(): void
    {
        $email = 'pasien.' . uniqid() . '@tend.clinic';

        $response = $this->post(route('register.post'), [
            'name'                  => 'Pasien Baru',
            'email'                 => $email,
            'phone'                 => '081233334444',
            'password'              => 'Password123!',
            'password_confirmation' => 'Password123!',
            'terms'                 => '1',
        ]);

        $response->assertRedirect(route('dashboard.index'));
        $newUser = User::where('email', $email)->first();
        $this->assertNotNull($newUser);
        $this->assertTrue($newUser->hasRole('user'));

        $newUser->delete();
    }

    public function test_admin_has_all_permissions_via_gate(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);
        $this->assertTrue(Gate::allows('any.arbitrary.permission'));

        $admin->delete();
    }
}
