<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {

            $table->enum('jenis', [
                'kegiatan',
                'rapat'
            ])->default('kegiatan');

            $table->foreignId('rapat_id')
                ->nullable()
                ->after('kegiatan_id')
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('validator_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {

            $table->dropForeign(['rapat_id']);
            $table->dropForeign(['validator_id']);

            $table->dropColumn([
                'jenis',
                'rapat_id',
                'validator_id',
            ]);

        });
    }
};