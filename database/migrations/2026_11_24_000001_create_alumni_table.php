<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->string('nrp', 12)->primary();
            $table->string('nama', 100);
            $table->string('prodi', 100);
            $table->smallInteger('tahun_lulus');
            $table->string('email', 150);
        });

        Schema::table('alumni', function (Blueprint $table) {
            $table->index('prodi', 'idx_alumni_prodi');
            $table->index('tahun_lulus', 'idx_alumni_tahun');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
