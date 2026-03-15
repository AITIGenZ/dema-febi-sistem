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
        $superAdmin = User::create([
            'name' => 'Ketua DEMA FEBI',
            'email' => 'ketua@demafebi.ac.id',
            'password' => Hash::make('password123'),
            'status' => 'aktif',
        ]);
        $superAdmin->assignRole('super_admin');

        // Buat akun Admin (Sekjen)
        $admin = User::create([
            'name' => 'Sekretaris Jenderal',
            'email' => 'sekjen@demafebi.ac.id',
            'password' => Hash::make('password123'),
            'status' => 'aktif',
        ]);
        $admin->assignRole('admin');

        // Buat akun Pengurus contoh
        $pengurus = User::create([
            'name' => 'Kepala Divisi',
            'email' => 'kadiv@demafebi.ac.id',
            'password' => Hash::make('password123'),
            'status' => 'aktif',
        ]);
        $pengurus->assignRole('pengurus');

        // Buat akun Anggota contoh
        $anggota = User::create([
            'name' => 'Anggota DEMA',
            'email' => 'anggota@demafebi.ac.id',
            'password' => Hash::make('password123'),
            'status' => 'aktif',
        ]);
        $anggota->assignRole('anggota');
    }
}