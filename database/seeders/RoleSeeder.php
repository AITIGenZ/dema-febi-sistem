<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        // Buat semua permission
        $permissions = [
            // Anggota
            'anggota.view',
            'anggota.create',
            'anggota.edit',
            'anggota.delete',
            // Divisi
            'divisi.view',
            'divisi.create',
            'divisi.edit',
            'divisi.delete',
            // Kegiatan
            'kegiatan.view',
            'kegiatan.create',
            'kegiatan.edit',
            'kegiatan.delete',
            // Pendaftaran
            'pendaftaran.view',
            'pendaftaran.create',
            'pendaftaran.edit',
            'pendaftaran.delete',
            // Absensi
            'absensi.view',
            'absensi.create',
            'absensi.edit',
            'absensi.delete',
            // Keuangan
            'iuran.view',
            'iuran.create',
            'iuran.edit',
            'iuran.delete',
            'kas.view',
            'kas.create',
            'kas.edit',
            'kas.delete',
            // Kalender
            'kalender.view',
            'kalender.create',
            'kalender.edit',
            'kalender.delete',
            // Dashboard
            'dashboard.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Role Pimpinan — semua permission
        $pimpinan = Role::firstOrCreate(['name' => 'pimpinan']);
        $pimpinan->syncPermissions($permissions);

        // Role Pengurus — terbatas
        $pengurus = Role::firstOrCreate(['name' => 'pengurus']);
        $pengurus->syncPermissions([
            // Dashboard hanya lihat
            'dashboard.view',
            // Anggota hanya lihat
            'anggota.view',
            // Divisi hanya lihat
            'divisi.view',
            // Kegiatan CRUD penuh
            'kegiatan.view',
            'kegiatan.create',
            'kegiatan.edit',
            'kegiatan.delete',
            // Pendaftaran hanya lihat
            'pendaftaran.view',
            // Absensi CRUD (input absensi kegiatan)
            'absensi.view',
            'absensi.create',
            'absensi.edit',
            'absensi.delete',
            // Kalender CRUD (input proker divisi)
            'kalender.view',
            'kalender.create',
            'kalender.edit',
            'kalender.delete',
            // Iuran & Kas hanya lihat
            'iuran.view',
            'kas.view',
        ]);
    }
}