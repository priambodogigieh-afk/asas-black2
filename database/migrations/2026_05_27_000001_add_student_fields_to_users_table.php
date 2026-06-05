<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('siswa')->after('password');
            }

            if (! Schema::hasColumn('users', 'kelas')) {
                $table->string('kelas')->nullable()->after('role');
            }

            if (! Schema::hasColumn('users', 'nis')) {
                $table->string('nis')->nullable()->unique()->after('kelas');
            }

            if (! Schema::hasColumn('users', 'jurusan')) {
                $table->string('jurusan')->nullable()->after('nis');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'jurusan')) {
                $table->dropColumn('jurusan');
            }

            if (Schema::hasColumn('users', 'nis')) {
                $table->dropUnique('users_nis_unique');
                $table->dropColumn('nis');
            }

            if (Schema::hasColumn('users', 'kelas')) {
                $table->dropColumn('kelas');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
