<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('praktikum_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('massa_panas', 8, 3);
            $table->decimal('massa_dingin', 8, 3);
            $table->decimal('kalor_jenis', 8, 2)->default(4200);
            $table->decimal('suhu_panas', 6, 2)->default(70);
            $table->decimal('suhu_dingin', 6, 2)->default(28);
            $table->decimal('suhu_campuran', 6, 2)->default(45);
            $table->decimal('q_lepas', 14, 2);
            $table->decimal('q_terima', 14, 2);
            $table->decimal('delta_q', 14, 2);
            $table->decimal('error_persen', 8, 2);
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('praktikum_histories');
    }
};
