<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage inventory',
            'process transactions',
            'view financial reports',
            'manage users'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roleKasir = Role::firstOrCreate(['name' => 'kasir']);
        $roleKasir->givePermissionTo(['process transactions']);

        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleAdmin->givePermissionTo([
            'manage inventory',
            'view financial reports',
            'manage users'
        ]);

        $admin = User::firstOrCreate(
            ['email' => env('SEEDUSER_EMAIL', 'admin@admin.com')],
            [
                'name' => 'Super Admin',
                'username' => env('SEEDUSER_NAME', 'superadmin'),
                'email' => env('SEEDUSER_EMAIL', 'admin@admin.com'),
                'password' => Hash::make(env('SEEDUSER_PWD', 'password')),
            ]
        );
        $admin->assignRole('admin');

        $kasir = User::firstOrCreate(
            ['email' => 'kasir@kasarung.com'],
            [
                'name' => 'Kasir Shift 1',
                'username' => 'kasir1',
                'email' => 'kasir@kasarung.com',
                'password' => Hash::make(env('SEEDUSER_PWD', 'password'))
            ]
        );
        $kasir->assignRole('kasir');
    }
}
