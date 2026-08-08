<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Menampilkan daftar semua Permission.
     */
    public function index()
    {
        // Eager load permissions for each task to avoid N+1 query issues.
        // Order by name for consistent display.
        $tasks = Task::with('permissions')->orderBy('name')->get();

        return view('admin.permissions.index', compact('tasks'));
    }

    /**
     * Menampilkan form tambah Permission.
     */
    public function create(Request $request)
    {
        return view('admin.permissions.create');
    }

    /**
     * Menyimpan Permission baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required|string|regex:/^[a-z0-9\-]+$/',
            'actions_list' => 'required|array|min:1',
            'actions_list.*' => 'required|string',
        ], [
            'task_name.required' => 'Nama modul/task wajib diisi.',
            'task_name.regex' => 'Nama modul/task hanya boleh berisi huruf kecil, angka, dan tanda hubung (-).',
            'actions_list.required' => 'Anda harus menambahkan setidaknya satu aksi permission.',
        ]);

        $taskName = $request->input('task_name');
        $actions = $request->input('actions_list');
        $count = 0;

        // 1. Cari atau buat Task baru
        $task = Task::firstOrCreate(['name' => $taskName]);

        foreach ($actions as $action) {
            $permissionName = "{$taskName}-{$action}";
            
            // Pastikan nama permission sesuai format (lowercase, no spaces)
            $permissionName = str_replace(' ', '-', strtolower($permissionName));

            // 2. Buat permission jika belum ada
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            // 3. Tautkan permission ke task
            $task->permissions()->syncWithoutDetaching($permission->id);
            $count++;
        }

        return redirect()->route('admin.permissions.index')->with('success', "Berhasil membuat/memastikan {$count} permission untuk modul '{$taskName}'.");
    }

    /**
     * Menampilkan form edit Permission.
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Memperbarui Permission.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission berhasil diperbarui.');
    }

    /**
     * Menghapus Permission.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission berhasil dihapus.');
    }

    /**
     * Menampilkan form untuk mengedit task dan permission-nya.
     */
    public function editTask(string $task_name)
    {
        $task = Task::where('name', $task_name)->with('permissions:name')->firstOrFail();

        // The view expects a variable named $taskName.
        $taskName = $task->name;

        // The view also expects an array of $actions.
        // We can derive this by taking the permission names and removing the task name prefix.
        // e.g., 'user-management-create' becomes 'create'.
        $actions = $task->permissions->map(function ($permission) use ($taskName) {
            return \Illuminate\Support\Str::after($permission->name, $taskName . '-');
        })->all();

        return view('admin.permissions.edit', compact('taskName', 'actions'));
    }

    /**
     * Memperbarui task dan permission-nya.
     */
    public function updateTask(Request $request, string $task_name)
    {
        $request->validate([
            'actions_list' => 'required|array|min:1',
            'actions_list.*' => 'required|string',
        ], [
            'actions_list.required' => 'Anda harus memiliki setidaknya satu aksi permission.',
        ]);

        DB::beginTransaction();
        try {
            $task = Task::where('name', $task_name)->firstOrFail();
            $newActions = $request->input('actions_list');
            $newPermissionNames = collect($newActions)->map(fn ($action) => "{$task->name}-{$action}");

            // Hapus permission lama yang tidak ada di list baru
            $permissionsToDelete = $task->permissions()->whereNotIn('name', $newPermissionNames)->get();
            foreach ($permissionsToDelete as $permission) {
                $permission->delete();
            }

            // Buat atau pastikan permission baru ada
            foreach ($newPermissionNames as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                $task->permissions()->syncWithoutDetaching($permission->id);
            }

            DB::commit();

            return redirect()->route('admin.permissions.index')->with('success', "Berhasil memperbarui permission untuk modul '{$task->name}'.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui permission: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus task beserta semua permission-nya.
     */
    public function destroyTask(string $task_name)
    {
        // This is a destructive action. Consider adding confirmation.
        // For now, we will just delete it.
        $task = Task::where('name', $task_name)->firstOrFail();
        
        // Deleting the task will also detach permissions.
        // The permissions themselves might remain if used by other tasks, which is often desired.
        // If you want to delete the permissions too, you'd need to iterate and delete them.
        $task->permissions()->delete(); // This deletes the related permissions records.
        $task->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', "Task '{$task_name}' dan semua permission terkait berhasil dihapus.");
    }
}