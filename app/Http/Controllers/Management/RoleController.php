<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->withCount(['users', 'permissions'])->orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        $roleStats = [
            'total_roles'       => $roles->count(),
            'total_users'       => $roles->sum('users_count'),
            'total_permissions' => $permissions->count(),
            'custom_roles'      => $roles->whereNotIn('name', ['admin', 'user'])->count(),
        ];

        return view('management.roles.index', compact('roles', 'permissions', 'roleStats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:100|unique:roles,name',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ], [
            'name.required' => 'Nama role wajib diisi.',
            'name.unique'   => 'Role dengan nama ini sudah ada.',
        ]);

        $role = Role::create([
            'name'       => strtolower(trim($request->name)),
            'guard_name' => 'web',
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions ?? []);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->to(route('management.roles.index') . '#/roles')
            ->with('success', "Role '{$role->name}' berhasil dibuat beserta hak aksesnya.");
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'          => "required|string|max:100|unique:roles,name,{$role->id}",
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ], [
            'name.required' => 'Nama role wajib diisi.',
            'name.unique'   => 'Nama role sudah digunakan.',
        ]);

        // Cegah perubahan nama role sistem (admin, user), tapi izinnya tetap boleh diatur
        if (!in_array($role->name, ['admin', 'user'])) {
            $role->update(['name' => strtolower(trim($request->name))]);
        }

        $role->syncPermissions($request->permissions ?? []);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->to(route('management.roles.index') . '#/roles')
            ->with('success', "Role '{$role->name}' dan hak aksesnya berhasil diperbarui.");
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, ['admin', 'user'])) {
            return redirect()->to(route('management.roles.index') . '#/roles')
                ->withErrors(['error' => "Role sistem '{$role->name}' tidak dapat dihapus."]);
        }

        $name = $role->name;
        $role->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->to(route('management.roles.index') . '#/roles')
            ->with('success', "Role '{$name}' berhasil dihapus.");
    }
}
