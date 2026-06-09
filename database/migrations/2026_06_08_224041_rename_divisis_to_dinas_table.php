<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel dinas sudah ada, skip rename
        // Hanya rename kolom di tabel lain

        // Rename kolom di users
        if (Schema::hasColumn('users', 'divisi_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('divisi_id', 'dinas_id');
            });
        }

        // Rename kolom di kegiatans
        if (Schema::hasColumn('kegiatans', 'divisi_id')) {
            Schema::table('kegiatans', function (Blueprint $table) {
                $table->renameColumn('divisi_id', 'dinas_id');
            });
        }

        // Rename kolom di kalender_prokers
        if (Schema::hasColumn('kalender_prokers', 'divisi_id')) {
            Schema::table('kalender_prokers', function (Blueprint $table) {
                $table->renameColumn('divisi_id', 'dinas_id');
            });
        }

        // Drop tabel divisis lama kalau masih ada
        Schema::dropIfExists('divisis');
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'dinas_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('dinas_id', 'divisi_id');
            });
        }

        if (Schema::hasColumn('kegiatans', 'dinas_id')) {
            Schema::table('kegiatans', function (Blueprint $table) {
                $table->renameColumn('dinas_id', 'divisi_id');
            });
        }

        if (Schema::hasColumn('kalender_prokers', 'dinas_id')) {
            Schema::table('kalender_prokers', function (Blueprint $table) {
                $table->renameColumn('dinas_id', 'divisi_id');
            });
        }
    }
};