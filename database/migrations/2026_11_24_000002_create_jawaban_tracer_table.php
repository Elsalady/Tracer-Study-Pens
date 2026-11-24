<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('DROP TYPE IF EXISTS status_kerja_t CASCADE');

        DB::statement("
            CREATE TYPE status_kerja_t AS ENUM
                ('BEKERJA', 'KULIAH_LANJUT', 'WIRAUSAHA', 'BELUM_BEKERJA')
        ");

        DB::statement("
            CREATE TABLE jawaban_tracer (
                id_jawaban bigserial PRIMARY KEY,
                nrp varchar(12) NOT NULL REFERENCES alumni(nrp),
                status_kerja status_kerja_t NOT NULL,
                nama_perusahaan varchar(150),
                bidang_pekerjaan varchar(100),
                jabatan varchar(100),
                tanggal_mulai date,
                skala_gaji varchar(20),
                relevansi smallint CHECK (relevansi BETWEEN 1 AND 5),
                lokasi_kabupaten varchar(100),
                submitted_at timestamptz NOT NULL DEFAULT now(),
                CHECK (
                    status_kerja <> 'BEKERJA'
                    OR (
                        nama_perusahaan IS NOT NULL
                        AND bidang_pekerjaan IS NOT NULL
                        AND jabatan IS NOT NULL
                        AND tanggal_mulai IS NOT NULL
                        AND relevansi IS NOT NULL
                    )
                )
            )
        ");

        DB::statement('CREATE INDEX idx_jawaban_status ON jawaban_tracer (status_kerja)');
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban_tracer');
        DB::statement('DROP TYPE IF EXISTS status_kerja_t');
    }
};
