<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionController extends Controller
{
    /**
     * Simpan Permission baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:permissions,name',
        ], [
            'name.required' => 'Nama permission wajib diisi.',
            'name.unique'   => 'Permission dengan nama ini sudah ada.',
        ]);

        $permission = Permission::create([
            'name'       => strtolower(trim($request->name)),
            'guard_name' => 'web',
        ]);

        // Otomatis assign ke role admin jika ada
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permission);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->to(route('management.role-permissions.index') . '#/role-permissions')
            ->with('success', "Permission '{$permission->name}' berhasil ditambahkan dan otomatis di-assign ke Admin.");
    }

    /**
     * Perbarui Permission
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => "required|string|max:100|unique:permissions,name,{$permission->id}",
        ], [
            'name.required' => 'Nama permission wajib diisi.',
            'name.unique'   => 'Permission dengan nama ini sudah ada.',
        ]);

        $oldName = $permission->name;
        $permission->update([
            'name' => strtolower(trim($request->name)),
        ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->to(route('management.role-permissions.index') . '#/role-permissions')
            ->with('success', "Permission '{$oldName}' berhasil diperbarui menjadi '{$permission->name}'.");
    }

    /**
     * Hapus Permission
     */
    public function destroy(Permission $permission)
    {
        $name = $permission->name;
        $permission->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->to(route('management.role-permissions.index') . '#/role-permissions')
            ->with('success', "Permission '{$name}' berhasil dihapus.");
    }
}
