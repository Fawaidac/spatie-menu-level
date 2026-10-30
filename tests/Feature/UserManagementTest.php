<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    public function test_unauthenticated_user_cannot_access_user_management(): void
    {
        $response = $this->get(route('management.users.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_management_users_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('management.users.index'));
        $response->assertStatus(200);

        $user->delete();
    }

    public function test_authenticated_user_can_create_update_and_delete_user(): void
    {
        $admin = User::factory()->create();
        $email = 'test.user.' . uniqid() . '@tend.clinic';

        // 1. Create
        $response = $this->actingAs($admin)->post(route('management.users.store'), [
            'name'     => 'Staf Baru',
            'email'    => $email,
            'phone'    => '081234567890',
            'password' => 'Password123!',
        ]);

        $response->assertRedirect(route('management.users.index') . '#/users');
        $this->assertDatabaseHas('users', ['email' => $email]);
        $newUser = User::where('email', $email)->first();

        // 2. Update
        $responseUpdate = $this->actingAs($admin)->put(route('management.users.update', $newUser), [
            'name'  => 'Staf Terupdate',
            'email' => $email,
            'phone' => '081299999999',
        ]);

        $responseUpdate->assertRedirect(route('management.users.index') . '#/users');
        $newUser->refresh();
        $this->assertSame('Staf Terupdate', $newUser->name);
        $this->assertSame('081299999999', $newUser->phone);

        // 3. Delete
        $responseDelete = $this->actingAs($admin)->delete(route('management.users.destroy', $newUser));
        $responseDelete->assertRedirect(route('management.users.index') . '#/users');
        $this->assertDatabaseMissing('users', ['id' => $newUser->id]);

        $admin->delete();
    }
}

