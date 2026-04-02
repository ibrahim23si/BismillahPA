<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('superadmin123'),
            'role' => 'super_admin',
            'email_verified_at' => now(),
        ]);

        // Buat Admin
        User::create([
            'name' => 'Admin Produksi',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Buat Kasir
        User::create([
            'name' => 'Kasir Keuangan',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir',
            'email_verified_at' => now(),
        ]);

        // Buat beberapa user tambahan untuk testing
        User::create([
            'name' => 'Admin Lapangan',
            'email' => 'admin2@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Kasir Junior',
            'email' => 'kasir2@test.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
            'email_verified_at' => now(),
        ]);

        $this->command->info('5 user berhasil dibuat!');
    }
}