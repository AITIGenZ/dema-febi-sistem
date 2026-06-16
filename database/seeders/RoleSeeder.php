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

        $permissions = [

            // Dashboard
            'dashboard.view',

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

            // Rapat
            'rapat.view',
            'rapat.create',
            'rapat.edit',
            'rapat.delete',
            'rapat.approve',

            // Absensi
            'absensi.view',
            'absensi.create',
            'absensi.edit',
            'absensi.delete',

            // Pendaftaran
            'pendaftaran.view',
            'pendaftaran.create',
            'pendaftaran.edit',
            'pendaftaran.delete',

            // Iuran
            'iuran.view',
            'iuran.create',
            'iuran.edit',
            'iuran.delete',

            // Kas
            'kas.view',
            'kas.create',
            'kas.edit',
            'kas.delete',

            // Kalender
            'kalender.view',
            'kalender.create',
            'kalender.edit',
            'kalender.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | KETUA
        |--------------------------------------------------------------------------
        */

        $ketua = Role::firstOrCreate([
            'name' => 'ketua',
        ]);

        $ketua->syncPermissions($permissions);

        /*
        |--------------------------------------------------------------------------
        | SEKRETARIS
        |--------------------------------------------------------------------------
        */

        $sekretaris = Role::firstOrCreate([
            'name' => 'sekretaris',
        ]);

        $sekretaris->syncPermissions([

            'dashboard.view',

            'anggota.view',
            'anggota.edit',

            'divisi.view',

            'kegiatan.view',
            'kegiatan.create',
            'kegiatan.edit',
            'kegiatan.delete',

            'rapat.view',
            'rapat.create',
            'rapat.edit',
            'rapat.delete',
            'rapat.approve',

            'absensi.view',
            'absensi.create',
            'absensi.edit',
            'absensi.delete',

            'kalender.view',
            'kalender.create',
            'kalender.edit',
            'kalender.delete',

            'pendaftaran.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | BENDAHARA
        |--------------------------------------------------------------------------
        */

        $bendahara = Role::firstOrCreate([
            'name' => 'bendahara',
        ]);

        $bendahara->syncPermissions([

            'dashboard.view',

            'iuran.view',
            'iuran.create',
            'iuran.edit',
            'iuran.delete',

            'kas.view',
            'kas.create',
            'kas.edit',
            'kas.delete',
        ]);

        /*
        |--------------------------------------------------------------------------
        | PENGURUS
        |--------------------------------------------------------------------------
        */

        $pengurus = Role::firstOrCreate([
            'name' => 'pengurus',
        ]);

        $pengurus->syncPermissions([

            'dashboard.view',

            'anggota.view',

            'divisi.view',

            'kegiatan.view',
            'kegiatan.create',

            'rapat.view',
            'rapat.create',

            'absensi.view',
            'absensi.create',

            'kalender.view',

            'pendaftaran.view',
        ]);
    }
}