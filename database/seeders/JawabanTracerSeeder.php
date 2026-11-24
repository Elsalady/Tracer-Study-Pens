<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JawabanTracerSeeder extends Seeder
{
    use WithoutModelEvents;

    private array $perusahaan = [
        'PT Telkom Indonesia', 'PT Ericsson Indonesia', 'PT Samsung R&D Indonesia',
        'PT Schneider Electric', 'PT Nokia Solutions', 'PT Batamtek Indonesia',
        'PT Sigma Cipta Caraka', 'PT Infosys Technologies', 'PT Huawei Tech Investment',
    ];

    private array $bidang = [
        'Teknologi Informasi', 'Telekomunikasi', 'Elektronika',
        'Manufaktur', 'Keuangan', 'Logistik',
    ];

    private array $jabatan = [
        'Frontend Developer', 'Backend Developer', 'Network Engineer',
        'Embedded Engineer', 'Data Analyst', 'Quality Assurance Engineer',
        'IT Support Specialist', 'Telecommunications Engineer',
    ];

    private array $kabupaten = [
        'Surabaya', 'Sidoarjo', 'Gresik', 'Malang', 'Jakarta Selatan',
        'Bandung', 'Semarang', 'Batam', 'Tangerang', 'Yogyakarta',
    ];

    private array $skalaGaji = [
        '<3000000',
        '3000000-5000000',
        '5000000-10000000',
        '>10000000',
    ];

    public function run(): void
    {
        $nrpAlumni = DB::table('alumni')->orderBy('nrp')->pluck('nrp')->all();

        mt_srand(20261124);
        $status = array_merge(
            array_fill(0, 65, 'BEKERJA'),
            array_fill(0, 15, 'KULIAH_LANJUT'),
            array_fill(0, 10, 'WIRAUSAHA'),
            array_fill(0, 10, 'BELUM_BEKERJA')
        );
        shuffle($status);

        mt_srand(20261125);
        $relevansi = array_merge(
            array_fill(0, 6, 5),
            array_fill(0, 35, 4),
            array_fill(0, 24, 3)
        );
        shuffle($relevansi);

        $jawaban = [];
        $indeksRelevansi = 0;

        foreach ($nrpAlumni as $i => $nrp) {
            $statusKerja = $status[$i];
            $bekerja = $statusKerja === 'BEKERJA';
            $bidang = $this->bidang[$i % count($this->bidang)];

            $jawaban[] = [
                'nrp' => $nrp,
                'status_kerja' => $statusKerja,
                'nama_perusahaan' => $bekerja ? $this->perusahaan[$i % count($this->perusahaan)] : null,
                'bidang_pekerjaan' => $bekerja ? $bidang : null,
                'jabatan' => $bekerja ? $this->jabatan[$i % count($this->jabatan)] : null,
                'tanggal_mulai' => $bekerja ? sprintf('2025-%02d-01', 1 + ($i % 12)) : null,
                'skala_gaji' => $bekerja ? $this->skalaGaji[$i % count($this->skalaGaji)] : null,
                'relevansi' => $bekerja ? $relevansi[$indeksRelevansi++] : null,
                'lokasi_kabupaten' => $bekerja ? $this->kabupaten[$i % count($this->kabupaten)] : null,
                'submitted_at' => sprintf('2026-11-%02d 09:15:00+07', 1 + ($i % 20)),
            ];
        }

        DB::table('jawaban_tracer')->insert($jawaban);
    }
}
