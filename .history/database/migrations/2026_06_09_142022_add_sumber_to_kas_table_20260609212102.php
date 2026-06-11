<?php
// database/migrations/2026_06_09_200000_add_sumber_to_kas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->enum('sumber', [
                'kas_bulanan',
                'iuran',
                'dana_kampus',
                'saldo_awal',
                'lainnya',
            ])->nullable()->after('jenis');
        });
    }

    public function down(): void
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->dropColumn('sumber');
        });
    }
};