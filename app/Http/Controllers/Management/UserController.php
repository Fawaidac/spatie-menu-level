<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $roleFilter = $request->get('role');

        $query = User::with(['roles', 'permissions'])->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($roleFilter && $roleFilter !== 'all') {
            $query->whereHas('roles', fn($q) => $q->where('name', $roleFilter));
        }

        $users = $query->get();
        $roles = Role::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        $userStats = [
            'total_users'    => User::count(),
            'active_users'   => User::whereNotNull('email_verified_at')->count(),
            'total_roles'    => $roles->count(),
            'new_this_month' => User::whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->count(),
        ];

        return view('management.users.index', compact('users', 'roles', 'permissions', 'userStats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'nullable|string|max:20',
            'role'          => 'required|exists:roles,name',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
            'password'      => ['required', Password::min(8)],
        ], [
            'name.required'     => 'Nama wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah digunakan.',
            'role.required'     => 'Role wajib dipilih.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'password'          => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        $user->syncRoles($request->role);

        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions ?? []);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->to(route('management.users.index') . '#/users')
            ->with('success', "Pengguna {$user->name} berhasil ditambahkan dengan role {$request->role}.");
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => "required|email|unique:users,email,{$user->id}",
            'phone'         => 'nullable|string|max:20',
            'role'          => 'required|exists:roles,name',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ], [
            'name.required'  => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique'   => 'Email sudah digunakan.',
            'role.required'  => 'Role wajib dipilih.',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => Password::min(8)]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles($request->role);
        $user->syncPermissions($request->permissions ?? []);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->to(route('management.users.index') . '#/users')
            ->with('success', "Data pengguna {$user->name} berhasil diperbarui.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->to(route('management.users.index') . '#/users')
                ->withErrors(['error' => 'Tidak dapat menghapus akun sendiri.']);
        }

        $name = $user->name;
        $user->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->to(route('management.users.index') . '#/users')
            ->with('success', "Pengguna {$name} berhasil dihapus.");
    }
}
