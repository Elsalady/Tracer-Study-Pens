<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\DashboardService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
        $this->actingAs(User::firstOrFail());
    }

    public function test_seed_menghasilkan_metrik_ringkasan_yang_diharapkan(): void
    {
        $this->assertDatabaseCount('alumni', 100);
        $this->assertDatabaseCount('jawaban_tracer', 100);

        $ringkasan = app(DashboardService::class)->ringkasan();

        $this->assertSame(100, $ringkasan['total_responden']);
        $this->assertSame(65, $ringkasan['total_bekerja']);
        $this->assertEqualsWithDelta(65.0, $ringkasan['tingkat_keterserapan'], 0.001);
        $this->assertEqualsWithDelta(3.72, $ringkasan['rata_rata_relevansi'], 0.001);
        $this->assertEqualsWithDelta(63.1, $ringkasan['persentase_relevan'], 0.001);

        $this->get(route('admin.dashboard.ringkasan'))
            ->assertOk()
            ->assertSee('100')
            ->assertSee('65%')
            ->assertSee('3,72')
            ->assertSee('63,1%');
    }

    public function test_tren_dan_komposisi_ringkasan_mengikuti_seed(): void
    {
        $ringkasan = app(DashboardService::class)->ringkasan();

        $this->assertCount(5, $ringkasan['tren']);
        $this->assertSame(100, array_sum(array_column($ringkasan['tren'], 'total_responden')));
        $this->assertSame(65, array_sum(array_column($ringkasan['tren'], 'total_bekerja')));
        $this->assertSame(100, array_sum(array_column($ringkasan['komposisi'], 'jumlah')));
        $this->assertCount(4, $ringkasan['komposisi']);
    }

    public function test_filter_ringkasan_bekerja_juga_mengubah_kpi(): void
    {
        $ringkasan = app(DashboardService::class)->ringkasan(['status_kerja' => 'BEKERJA']);

        $this->assertSame(65, $ringkasan['total_responden']);
        $this->assertEqualsWithDelta(100.0, $ringkasan['tingkat_keterserapan'], 0.001);
        $this->assertSame(65, array_sum(array_column($ringkasan['komposisi'], 'jumlah')));
    }

    public function test_filter_kosong_ringkasan_tidak_error(): void
    {
        $ringkasan = app(DashboardService::class)->ringkasan(['tahun_lulus' => 1999]);

        $this->assertSame(0, $ringkasan['total_responden']);
        $this->assertSame([], $ringkasan['tren']);
        $this->assertSame(0, array_sum(array_column($ringkasan['komposisi'], 'jumlah')));

        $this->get(route('admin.dashboard.ringkasan', ['tahun_lulus' => 1999]))
            ->assertOk()
            ->assertSee('Tidak ada data');
    }
}
