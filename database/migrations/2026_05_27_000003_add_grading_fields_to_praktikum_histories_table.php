<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('praktikum_histories', function (Blueprint $table) {
            if (! Schema::hasColumn('praktikum_histories', 'nilai')) {
                $table->unsignedTinyInteger('nilai')->nullable()->after('status');
            }

            if (! Schema::hasColumn('praktikum_histories', 'catatan_nilai')) {
                $table->text('catatan_nilai')->nullable()->after('nilai');
            }

            if (! Schema::hasColumn('praktikum_histories', 'dinilai_oleh')) {
                $table->foreignId('dinilai_oleh')->nullable()->after('catatan_nilai')->constrained('users')->nullOnDelete();
            }

            if (! Schema::hasColumn('praktikum_histories', 'dinilai_pada')) {
                $table->timestamp('dinilai_pada')->nullable()->after('dinilai_oleh');
            }
        });
    }

    public function down(): void
    {
        Schema::table('praktikum_histories', function (Blueprint $table) {
            if (Schema::hasColumn('praktikum_histories', 'dinilai_oleh')) {
                $table->dropConstrainedForeignId('dinilai_oleh');
            }

            foreach (['dinilai_pada', 'catatan_nilai', 'nilai'] as $column) {
                if (Schema::hasColumn('praktikum_histories', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
