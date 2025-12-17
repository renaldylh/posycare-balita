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
        Schema::table('pengukuran', function (Blueprint $table) {
            // Add columns without specifying 'after' to avoid dependency issues
            if (!Schema::hasColumn('pengukuran', 'status_gizi_ml')) {
                $table->string('status_gizi_ml')->nullable();
            }
            if (!Schema::hasColumn('pengukuran', 'bmi')) {
                $table->decimal('bmi', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('pengukuran', 'rekomendasi')) {
                $table->text('rekomendasi')->nullable();
            }
            if (!Schema::hasColumn('pengukuran', 'tanggal_pengukuran')) {
                $table->date('tanggal_pengukuran')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengukuran', function (Blueprint $table) {
            if (Schema::hasColumn('pengukuran', 'status_gizi_ml')) {
                $table->dropColumn('status_gizi_ml');
            }
            if (Schema::hasColumn('pengukuran', 'bmi')) {
                $table->dropColumn('bmi');
            }
            if (Schema::hasColumn('pengukuran', 'rekomendasi')) {
                $table->dropColumn('rekomendasi');
            }
            if (Schema::hasColumn('pengukuran', 'tanggal_pengukuran')) {
                $table->dropColumn('tanggal_pengukuran');
            }
        });
    }
};
