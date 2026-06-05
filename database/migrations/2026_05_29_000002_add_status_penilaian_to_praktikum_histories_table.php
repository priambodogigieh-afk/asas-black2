<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('praktikum_histories', function (Blueprint $table) {
            if (! Schema::hasColumn('praktikum_histories', 'status_penilaian')) {
                $table->string('status_penilaian', 20)->nullable()->after('catatan_nilai');
            }
        });
    }

    public function down(): void
    {
        Schema::table('praktikum_histories', function (Blueprint $table) {
            if (Schema::hasColumn('praktikum_histories', 'status_penilaian')) {
                $table->dropColumn('status_penilaian');
            }
        });
    }
};
