<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            
            // ===== TAMBAHKAN KOLOM-KOLOM INI =====
            // Relasi ke user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Informasi dasar event
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            
            // Waktu event
            $table->dateTime('start');
            $table->dateTime('end')->nullable();
            $table->boolean('is_all_day')->default(false);
            
            // Kategori dan status
            $table->enum('type', ['meeting', 'deadline', 'reminder', 'task'])
                  ->default('meeting');
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])
                  ->default('scheduled');
            
            // Fitur tambahan
            $table->integer('reminder_minutes')->nullable();
            $table->string('recurrence_rule')->nullable(); // Untuk event berulang
            $table->string('color', 7)->nullable(); // Format hex: #FF0000
            $table->json('metadata')->nullable(); // Data tambahan fleksibel
            
            // ===== JANGAN HAPUS INI =====
            $table->timestamps(); // created_at dan updated_at
            $table->softDeletes(); // deleted_at (opsional, untuk soft delete)
            
            // Index untuk optimasi performa
            $table->index(['user_id', 'start']);
            $table->index(['status', 'start']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};