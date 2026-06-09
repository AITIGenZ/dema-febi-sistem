<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ketua

        $ketua = User::updateOrCreate(
            [
                'email' => 'ketua@demafebi.ac.id',
            ],
            [
                'name' => 'Ketua DEMA FEBI',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
            ]
        );

        $ketua->syncRoles(['ketua']);

        // Sekretaris

        $sekretaris = User::updateOrCreate(
            [
                'email' => 'sekretaris@demafebi.ac.id',
            ],
            [
                'name' => 'Sekretaris DEMA FEBI',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
            ]
        );

        $sekretaris->syncRoles(['sekretaris']);

        // Bendahara

        $bendahara = User::updateOrCreate(
            [
                'email' => 'bendahara@demafebi.ac.id',
            ],
            [
                'name' => 'Bendahara DEMA FEBI',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
            ]
        );

        $bendahara->syncRoles(['bendahara']);

        // Pengurus

        $pengurus = User::updateOrCreate(
            [
                'email' => 'pengurus@demafebi.ac.id',
            ],
            [
                'name' => 'Pengurus DEMA',
                'password' => Hash::make('password123'),
                'status' => 'aktif',
            ]
        );

        $pengurus->syncRoles(['pengurus']);
    }
}