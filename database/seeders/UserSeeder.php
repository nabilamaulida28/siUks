<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin UKS
        User::updateOrCreate(
            ['email' => 'admin@siuks.sch.id'],
            [
                'name' => 'Administrator UKS',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081234567890',
                'position' => 'Koordinator UKS',
                'is_active' => true,
            ]
        );

        // 2. Petugas UKS 1
        User::updateOrCreate(
            ['email' => 'petugas@siuks.sch.id'],
            [
                'name' => 'Siti Rahmawati, A.Md.Kep',
                'password' => Hash::make('password'),
                'role' => 'officer',
                'phone' => '082198765432',
                'position' => 'Perawat UKS',
                'is_active' => true,
            ]
        );

        // 3. Petugas UKS 2
        User::updateOrCreate(
            ['email' => 'budi.petugas@siuks.sch.id'],
            [
                'name' => 'Budi Setiawan, S.Kep',
                'password' => Hash::make('password'),
                'role' => 'officer',
                'phone' => '085712345678',
                'position' => 'Petugas UKS',
                'is_active' => true,
            ]
        );

        // 4. Akun Siswa Dummy untuk Login
        User::updateOrCreate(
            ['email' => 'siswa@siuks.sch.id'],
            [
                'name' => 'Aditya Pratama',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '087811223344',
                'position' => 'Siswa',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'anisa@siuks.sch.id'],
            [
                'name' => 'Anisa Rahmawati',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '087822334455',
                'position' => 'Siswa',
                'is_active' => true,
            ]
        );
    }
}
