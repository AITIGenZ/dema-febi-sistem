<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {

            $table->decimal('checkin_latitude', 10, 7)
                ->nullable()
                ->after('validator_id');

            $table->decimal('checkin_longitude', 10, 7)
                ->nullable()
                ->after('checkin_latitude');

            $table->timestamp('checkin_at')
                ->nullable()
                ->after('checkin_longitude');

        });
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {

            $table->dropColumn([
                'checkin_latitude',
                'checkin_longitude',
                'checkin_at',
            ]);

        });
    }
};