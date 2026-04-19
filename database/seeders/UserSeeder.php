<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun Super Admin (Ketua)
        $superAdmin = User::updateOrCreate(
            ['email' => 'ketua@demafebi.ac.id'],
            [
                'name' => 'Ketua DEMA FEBI',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
            ]
        );
        $superAdmin->assignRole('super_admin');

        // Buat akun Admin (Sekjen)
        $admin = User::updateOrCreate(
            ['email' => 'sekjen@demafebi.ac.id'],
            [
                'name' => 'Sekretaris Jenderal',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
            ]
        );
        $admin->assignRole('admin');

        // Buat akun Pengurus contoh
        $pengurus = User::updateOrCreate(
            ['email' => 'kadiv@demafebi.ac.id'],
            [
                'name' => 'Kepala Divisi',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
            ]
        );
        $pengurus->assignRole('pengurus');

        // Buat akun Anggota contoh
        $anggota = User::updateOrCreate(
            ['email' => 'anggota@demafebi.ac.id'],
            [
                'name' => 'Anggota DEMA',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
            ]
        );
        $anggota->assignRole('anggota');
    }
}