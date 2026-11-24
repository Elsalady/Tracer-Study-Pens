<?php

namespace Tests\Feature;

use App\Services\DashboardService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_seed_menghasilkan_metrik_ringkasan_yang_diharapkan(): void
    {
        $this->seed(DatabaseSeeder::class);

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
}
