<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran_kas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kas_setting_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kas_id')->nullable()->constrained('kas')->nullOnDelete();
            $table->integer('bulan')->nullable();
            $table->integer('tahun');
            $table->decimal('nominal', 12, 2);
            $table->enum('status', ['lunas', 'belum'])->default('belum');
            $table->date('tgl_bayar')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'kas_setting_id', 'bulan', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_kas');
    }
};