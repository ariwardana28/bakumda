<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Task;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Menampilkan daftar semua Role.
     */
    public function index()
    {
        // Ambil semua role beserta permission yang terhubung dengannya
        $roles = Role::with('permissions')->get();
        
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Menampilkan form tambah Role baru.
     */
    public function create()
    {
        // Ambil semua Task beserta relasi permissions-nya
        $tasks = Task::with('permissions')->orderBy('name')->get();

        return view('admin.roles.create', compact('tasks'));
    }

    /**
     * Menyimpan Role baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        // 1. Buat Role
        $role = Role::create(['name' => $request->name]);

        // 2. Tempelkan permission ke role jika ada yang dipilih
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.role.index')
            ->with('success', 'Role berhasil dibuat.');
    }

    /**
     * Menampilkan form edit Role.
     */
    public function edit(Role $role)
    {
        // Ambil semua Task beserta relasi permissions-nya
        $tasks = Task::with('permissions')->orderBy('name')->get();
        
        // Ambil ID / nama permission yang saat ini dimiliki oleh role ini
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'tasks', 'rolePermissions'));
    }

    /**
     * Memperbarui Role dan Permission-nya.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        // 1. Update nama role
        $role->update(['name' => $request->name]);

        // 2. Synchronize permissions (otomatis menghapus yang di-uncheck dan menambah yang di-check)
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.role.index')
            ->with('success', 'Role berhasil diperbarui.');
    }

    /**
     * Menghapus Role.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('admin.role.index')
            ->with('success', 'Role berhasil dihapus.');
    }
}
