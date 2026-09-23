<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Daftar 12 Permission Sesuai Gambar
        $permissions = [
            'manage-users',
            'manage-roles',
            'manage-permissions',
            'delete-users',
            'edit-users',
            'create-users',
            'delete-role',
            'edit-role',
            'create-role',
            'delete-permissions',
            'edit-permissions',
            'create-permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Buat Role Super Admin & Assign Semua Permission
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdminRole->syncPermissions(Permission::all());

        // 3. Buat Role Admin (Tanpa Permission Manajemen Sesuai Kebutuhan)
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // 4. Buat User Super Admin
        $user = User::firstOrCreate(
            ['email' => 'sadmin@gmail.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('sadmin123'),
            ]
        );

        // Assign Role Super Admin ke User
        $user->assignRole($superAdminRole);
    }
}
