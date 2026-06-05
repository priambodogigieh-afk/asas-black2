<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('praktikum_histories', function (Blueprint $table) {
            if (Schema::hasColumn('praktikum_histories', 'nama_kelompok')) {
                $table->dropColumn('nama_kelompok');
            }
        });

        Schema::dropIfExists('sensor_data');
        Schema::dropIfExists('praktikum');
    }

    public function down(): void
    {
        Schema::table('praktikum_histories', function (Blueprint $table) {
            if (! Schema::hasColumn('praktikum_histories', 'nama_kelompok')) {
                $table->string('nama_kelompok')->nullable()->after('user_id');
            }
        });

        if (! Schema::hasTable('praktikum')) {
            Schema::create('praktikum', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->decimal('massa_panas', 8, 2)->default(100);
                $table->decimal('massa_dingin', 8, 2)->default(100);
                $table->decimal('kalor_jenis', 8, 2)->default(4.18);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('sensor_data')) {
            Schema::create('sensor_data', function (Blueprint $table) {
                $table->id();
                $table->foreignId('praktikum_id')->constrained('praktikum')->cascadeOnDelete();
                $table->decimal('suhu_panas', 6, 2);
                $table->decimal('suhu_dingin', 6, 2);
                $table->decimal('suhu_campuran', 6, 2);
                $table->decimal('q_lepas', 12, 2);
                $table->decimal('q_terima', 12, 2);
                $table->decimal('error_persen', 8, 2);
                $table->string('status');
                $table->timestamps();
            });
        }
    }
};
