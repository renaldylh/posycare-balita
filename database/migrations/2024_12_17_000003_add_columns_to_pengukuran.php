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
            // Add required columns for pengukuran
            if (!Schema::hasColumn('pengukuran', 'id_balita')) {
                $table->unsignedBigInteger('id_balita')->nullable()->after('id');
            }
            if (!Schema::hasColumn('pengukuran', 'id_user')) {
                $table->unsignedBigInteger('id_user')->nullable()->after('id_balita');
            }
            if (!Schema::hasColumn('pengukuran', 'usia_bulan')) {
                $table->integer('usia_bulan')->after('id_user');
            }
            if (!Schema::hasColumn('pengukuran', 'berat_badan')) {
                $table->decimal('berat_badan', 5, 2)->after('usia_bulan');
            }
            if (!Schema::hasColumn('pengukuran', 'tinggi_badan')) {
                $table->decimal('tinggi_badan', 5, 2)->after('berat_badan');
            }
            if (!Schema::hasColumn('pengukuran', 'lingkar_kepala')) {
                $table->decimal('lingkar_kepala', 5, 2)->after('tinggi_badan');
            }
            if (!Schema::hasColumn('pengukuran', 'lila')) {
                $table->decimal('lila', 5, 2)->after('lingkar_kepala');
            }
        });

        // Rename 'id' to 'id_pengukuran' to match model expectations
        if (Schema::hasColumn('pengukuran', 'id') && !Schema::hasColumn('pengukuran', 'id_pengukuran')) {
            Schema::table('pengukuran', function (Blueprint $table) {
                $table->renameColumn('id', 'id_pengukuran');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('pengukuran', 'id_pengukuran')) {
            Schema::table('pengukuran', function (Blueprint $table) {
                $table->renameColumn('id_pengukuran', 'id');
            });
        }

        Schema::table('pengukuran', function (Blueprint $table) {
            $columns = ['id_balita', 'id_user', 'usia_bulan', 'berat_badan', 'tinggi_badan', 'lingkar_kepala', 'lila'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('pengukuran', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
