<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Pimpinan — Ketua Umum
        $ketua = User::updateOrCreate(
            ['email' => 'ketua@demafebi.ac.id'],
            [
                'name' => 'Ketua DEMA FEBI',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
            ]
        );
        $ketua->syncRoles(['pimpinan']);

        // Akun Pimpinan — Sekretaris
        $sekretaris = User::updateOrCreate(
            ['email' => 'sekretaris@demafebi.ac.id'],
            [
                'name' => 'Sekretaris DEMA FEBI',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
            ]
        );
        $sekretaris->syncRoles(['pimpinan']);

        // Akun Pimpinan — Bendahara
        $bendahara = User::updateOrCreate(
            ['email' => 'bendahara@demafebi.ac.id'],
            [
                'name' => 'Bendahara DEMA FEBI',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
            ]
        );
        $bendahara->syncRoles(['pimpinan']);

        // Akun Pengurus — Kepala Dinas
        $kadiv = User::updateOrCreate(
            ['email' => 'kadis@demafebi.ac.id'],
            [
                'name' => 'Kepala Dinas',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
            ]
        );
        $kadiv->syncRoles(['pengurus']);

        // Akun Pengurus — Staf Dinas
        $staf = User::updateOrCreate(
            ['email' => 'staf@demafebi.ac.id'],
            [
                'name' => 'Staf Dinas',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
            ]
        );
        $staf->syncRoles(['pengurus']);
    }
}