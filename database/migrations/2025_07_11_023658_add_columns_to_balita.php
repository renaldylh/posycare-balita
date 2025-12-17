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
        Schema::table('balita', function (Blueprint $table) {
            // Add required columns (id_balita already exists as 'id')
            if (!Schema::hasColumn('balita', 'nama_balita')) {
                $table->string('nama_balita')->after('id');
            }
            if (!Schema::hasColumn('balita', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['L', 'P'])->after('nama_balita');
            }
            if (!Schema::hasColumn('balita', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->after('jenis_kelamin');
            }
            if (!Schema::hasColumn('balita', 'nama_ortu')) {
                $table->string('nama_ortu')->nullable()->after('tanggal_lahir');
            }
            if (!Schema::hasColumn('balita', 'alamat')) {
                $table->text('alamat')->nullable()->after('nama_ortu');
            }
        });

        // Rename 'id' to 'id_balita' to match model expectations
        Schema::table('balita', function (Blueprint $table) {
            $table->renameColumn('id', 'id_balita');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('balita', function (Blueprint $table) {
            $table->renameColumn('id_balita', 'id');
        });

        Schema::table('balita', function (Blueprint $table) {
            $columns = ['nama_balita', 'jenis_kelamin', 'tanggal_lahir', 'nama_ortu', 'alamat'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('balita', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
