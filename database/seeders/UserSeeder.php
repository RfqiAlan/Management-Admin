<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        User::updateOrCreate(
            ['email' => 'admin@kampus.test'],
            [
                'name'     => 'Admin Kampus',
                'password' => Hash::make('password123'), // ganti nanti
                'role'     => 'admin',
                'phone'    => '081234567890',
            ]
        );

        // MAHASISWA DEMO
        User::updateOrCreate(
            ['email' => 'mahasiswa1@kampus.test'],
            [
                'name'     => 'Mahasiswa Satu',
                'password' => Hash::make('password123'),
                'role'     => 'student',
                'phone'    => '081234567891',
            ]
        );

        User::updateOrCreate(
            ['email' => 'mahasiswa2@kampus.test'],
            [
                'name'     => 'Mahasiswa Dua',
                'password' => Hash::make('password123'),
                'role'     => 'student',
                'phone'    => '081234567892',
            ]
        );
    }
}
