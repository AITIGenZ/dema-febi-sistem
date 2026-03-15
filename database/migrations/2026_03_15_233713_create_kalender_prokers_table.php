<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kalender_prokers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')
                ->constrained()->cascadeOnDelete();
            $table->foreignId('divisi_id')->nullable()
                ->constrained()->nullOnDelete();
            $table->date('tgl_mulai');
            $table->date('tgl_selesai')->nullable();
            $table->string('warna')->default('#3B82F6');
            $table->boolean('is_publik')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kalender_prokers');
    }
};
