<?php
// database/migrations/2026_06_09_200003_create_kas_liburs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kas_liburs', function (Blueprint $table) {
            $table->id();
            $table->integer('bulan'); // 1-12
            $table->integer('tahun');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['bulan', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kas_liburs');
    }
};