<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumniSeeder extends Seeder
{
    use WithoutModelEvents;

    private array $nama = [
        'Arif Pratama', 'Budi Santoso', 'Citra Maharani', 'Dewi Anggraini',
        'Eko Purnomo', 'Fajar Ramadhan', 'Gita Wulandari', 'Hendra Gunawan',
        'Indah Permata', 'Joko Susilo', 'Karin Aulia', 'Luki Haryono',
        'Maya Sari', 'Nanda Kusuma', 'Oki Setiawan', 'Putri Anindya',
        'Rizky Ananda', 'Siti Rahayu', 'Teguh Prasetyo', 'Umi Kalsum',
        'Vino Prakoso', 'Wulan Darmawan', 'Yusuf Maulana', 'Zahra Nabila',
    ];

    private array $prodi = [
        'Teknik Informatika',
        'Teknik Komputer',
        'Teknik Elektronika',
        'Teknik Telekomunikasi',
    ];

    public function run(): void
    {
        $alumni = [];

        for ($i = 0; $i < 100; $i++) {
            $alumni[] = [
                'nrp' => sprintf('3124521%03d', $i + 1),
                'nama' => $this->nama[$i % count($this->nama)],
                'prodi' => $this->prodi[$i % count($this->prodi)],
                'tahun_lulus' => 2021 + ($i % 5),
                'email' => sprintf('alumni%03d@example.com', $i + 1),
            ];
        }

        DB::table('alumni')->insert($alumni);
    }
}
