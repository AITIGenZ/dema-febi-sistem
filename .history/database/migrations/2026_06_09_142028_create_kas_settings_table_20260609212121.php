<?php
// database/migrations/2026_06_09_200001_create_kas_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kas_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['bulanan', 'temporal']);
            $table->string('nama')->nullable(); // untuk temporal: nama event
            $table->decimal('nominal', 12, 2)->default(2000);
            $table->date('berlaku_mulai')->nullable(); // untuk bulanan
            $table->date('berlaku_sampai')->nullable(); // untuk temporal
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kas_settings');
    }
};