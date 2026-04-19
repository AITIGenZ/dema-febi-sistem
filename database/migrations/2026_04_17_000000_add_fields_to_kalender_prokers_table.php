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
        Schema::table('kalender_prokers', function (Blueprint $table) {
            // Tambah field status untuk tracking state event
            if (!Schema::hasColumn('kalender_prokers', 'status')) {
                $table->string('status')->default('scheduled')->after('is_publik');
            }

            // Tambah field reminder_at untuk pengingat sebelum event
            if (!Schema::hasColumn('kalender_prokers', 'reminder_at')) {
                $table->dateTime('reminder_at')->nullable()->after('status');
            }

            // Tambah field created_by untuk tracking siapa yang membuat
            if (!Schema::hasColumn('kalender_prokers', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->after('reminder_at');
            }

            // Tambah field updated_by untuk tracking siapa yang mengubah
            if (!Schema::hasColumn('kalender_prokers', 'updated_by')) {
                $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete()->after('created_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kalender_prokers', function (Blueprint $table) {
            if (Schema::hasColumn('kalender_prokers', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('kalender_prokers', 'reminder_at')) {
                $table->dropColumn('reminder_at');
            }
            if (Schema::hasColumn('kalender_prokers', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('kalender_prokers', 'updated_by')) {
                $table->dropForeign(['updated_by']);
                $table->dropColumn('updated_by');
            }
        });
    }
};
