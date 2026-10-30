<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles       = Role::with('permissions')->withCount('permissions')->orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        // Kelompokkan permission berdasarkan prefix (user, role, permission, etc.)
        $groups = $permissions->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });

        return view('management.role-permissions.index', compact('roles', 'permissions', 'groups'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'role_id'        => 'required|exists:roles,id',
            'permissions'    => 'nullable|array',
            'permissions.*'  => 'exists:permissions,id',
        ]);

        $role = Role::findById($request->role_id);
        $permissionNames = Permission::whereIn('id', $request->permissions ?? [])->pluck('name');
        $role->syncPermissions($permissionNames);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->to(route('management.role-permissions.index') . '#/role-permissions')
            ->with('success', "Hak akses role '{$role->name}' berhasil diperbarui.");
    }
}
