<?php

namespace Tests\Feature;

use App\Services\DataJawabanService;
use App\Services\KeterserapanService;
use App\Services\ProfilAlumniService;
use App\Services\RelevansiService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_halaman_keterserapan(): void
    {
        $data = app(KeterserapanService::class)->data();

        $this->assertSame(100, $data['total_responden']);
        $this->assertSame(65, $data['total_bekerja']);
        $this->assertEqualsWithDelta(65.0, $data['persentase'], 0.001);
        $this->assertSame(100, array_sum(array_column($data['per_prodi'], 'total_responden')));
        $this->assertSame(65, array_sum(array_column($data['per_prodi'], 'total_bekerja')));

        $this->get(route('admin.dashboard.keterserapan'))
            ->assertOk()
            ->assertSee('65 dari 100 responden bekerja (65%)');
    }

    public function test_halaman_relevansi(): void
    {
        $data = app(RelevansiService::class)->data();
        $jumlahSkor = array_sum(array_map(fn ($row) => $row['skor'] * $row['jumlah'], $data['distribusi']));

        $this->assertSame(65, $data['total_dinilai']);
        $this->assertSame(65, array_sum(array_column($data['distribusi'], 'jumlah')));
        $this->assertEqualsWithDelta(3.72, round($jumlahSkor / 65, 2), 0.001);
        $this->assertEqualsWithDelta(3.72, $data['rata_rata'], 0.001);

        foreach ([$data['bidang_terbaik'], $data['bidang_terendah']] as $daftar) {
            foreach ($daftar as $row) {
                $this->assertGreaterThanOrEqual(3, $row['total_dinilai']);
            }
        }

        $terbaik = array_column($data['bidang_terbaik'], 'bidang');
        $terendah = array_column($data['bidang_terendah'], 'bidang');
        $this->assertEmpty(array_intersect($terbaik, $terendah));

        $this->get(route('admin.dashboard.relevansi'))
            ->assertOk()
            ->assertSee('3,72')
            ->assertSee('63,1%');
    }

    public function test_halaman_profil_alumni(): void
    {
        $data = app(ProfilAlumniService::class)->data();
        $label = ['<3000000', '3000000-5000000', '5000000-10000000', '>10000000'];

        $this->assertSame(65, $data['total_bekerja']);
        $this->assertSame(65, array_sum(array_column($data['bidang'], 'jumlah')));
        $this->assertSame(65, array_sum(array_column($data['skala_gaji'], 'jumlah')));
        $this->assertSame(65, array_sum(array_column($data['kabupaten'], 'jumlah')));
        $this->assertSame($label, $data['skala_gaji_label']);
        $this->assertSame($label, array_column($data['skala_gaji'], 'label'));
        $this->assertLessThanOrEqual(10, count($data['kabupaten_top']));

        $this->get(route('admin.dashboard.profil-alumni'))
            ->assertOk()
            ->assertSee('3000000-5000000');
    }

    public function test_halaman_data_jawaban_pencarian_dan_pagination(): void
    {
        $paginator = app(DataJawabanService::class)->data();

        $this->assertSame(100, $paginator->total());
        $this->assertSame(25, $paginator->perPage());
        $this->assertCount(25, $paginator->items());

        $this->assertSame(65, app(DataJawabanService::class)->data(['q' => 'pt'])->total());

        $this->get(route('admin.dashboard.data-jawaban', ['q' => 'pt']))
            ->assertOk()
            ->assertSee('Menampilkan 65 jawaban')
            ->assertSee('q=pt', false);
    }

    public function test_filter_kosong_semua_halaman_tidak_error(): void
    {
        $rute = [
            'admin.dashboard.ringkasan',
            'admin.dashboard.keterserapan',
            'admin.dashboard.relevansi',
            'admin.dashboard.profil-alumni',
            'admin.dashboard.data-jawaban',
        ];

        foreach ($rute as $nama) {
            $this->get(route($nama, ['tahun_lulus' => 1999]))
                ->assertOk()
                ->assertSee('Tidak ada data');
        }
    }
}
