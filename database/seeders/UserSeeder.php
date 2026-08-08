<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Role Super Admin dan berikan semua permission
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // 2. Buat User Super Admin
        $superAdminUser = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'), // Ganti dengan password yang aman
        ]);
        $superAdminUser->assignRole($superAdminRole);

        // 3. Buat Role Staff dengan permission terbatas
        $staffRole = Role::create(['name' => 'Staff']);
        $staffRole->givePermissionTo([
            'anggota-view',
            'anggota-create',
            'anggota-edit',
        ]);

        // 4. Buat User Staff
        $staffUser = User::factory()->create([
            'name' => 'Staff User',
            'email' => 'staff@gmail.com',
            'password' => bcrypt('password'), // Ganti dengan password yang aman
        ]);
        $staffUser->assignRole($staffRole);

        // 5. Buat Role Anggota (tanpa permission khusus, hanya sebagai penanda)
        Role::create(['name' => 'Anggota']);
    }
}
