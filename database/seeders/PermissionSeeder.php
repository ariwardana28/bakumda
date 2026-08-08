<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar permissions
        $permissions = [
            // Anggota
            'anggota-view',
            'anggota-create',
            'anggota-edit',
            'anggota-delete',

            // Role & Permission
            'role-view',
            'role-create',
            'role-edit',
            'role-delete',

            // User
            'user-view',
            'user-edit', // Biasanya hanya edit role

            'kartu-anggota-view',
            'kartu-anggota-show',
            'kartu-anggota-download',

            'status-anggota-view',

            'keanggotaan-view',
            'keanggotaan-create',
            'keanggotaan-download',
        ];

        // Buat permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}