<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat semua role
        $roles = ['admin', 'ketua', 'sekretaris', 'bendahara', 'anggota'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // Buat admin default
        $admin = User::firstOrCreate(
            ['email' => 'admin@demafebi.ac.id'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('password'),
                'status'   => 'aktif',
                'phone'    => '081234567890',
            ]
        );

        $admin->assignRole('admin');

        $this->command->info('✅ Roles dan admin user berhasil dibuat.');
        $this->command->info('📧 Email: admin@demafebi.ac.id');
        $this->command->info('🔑 Password: password');
    }
}