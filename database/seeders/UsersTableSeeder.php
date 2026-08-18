<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan updateOrCreate agar tidak error duplicate entry jika seeder dijalankan ulang
        User::updateOrCreate(
            ['email' => env('SEEDUSER_EMAIL', 'admin@admin.com')], // Kondisi pencarian
            [
                'name' => 'Administrator',
                'email' => env('SEEDUSER_EMAIL', 'admin@admin.com'),
                'username' => env('SEEDUSER_NAME', 'admin_super'),
                'email_verified_at' => now(),
                'password' => Hash::make(env('SEEDUSER_PWD', 'password')),
            ]
        );
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'username' => 'user_biasa',
                'email_verified_at' => now(),
                'password' => Hash::make('Secret321!'),
            ]
        );

        User::factory()->count(3)->create();
    }
}
