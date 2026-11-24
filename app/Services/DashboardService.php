<?php

namespace App\Services;

use App\Models\JawabanTracer;

class DashboardService
{
    public function ringkasan(): array
    {
        $totalResponden = JawabanTracer::query()->count();
        $totalBekerja = JawabanTracer::query()
            ->where('status_kerja', 'BEKERJA')
            ->count();

        $tingkatKeterserapan = $totalResponden > 0
            ? round($totalBekerja / $totalResponden * 100, 1)
            : 0.0;

        $relevansi = JawabanTracer::query()
            ->where('status_kerja', 'BEKERJA')
            ->whereNotNull('relevansi');

        $totalDinilai = (clone $relevansi)->count();
        $rataRata = (clone $relevansi)->avg('relevansi');
        $totalRelevan = (clone $relevansi)
            ->where('relevansi', '>=', 4)
            ->count();

        $rataRataRelevansi = $rataRata !== null ? round((float) $rataRata, 2) : 0.0;
        $persentaseRelevan = $totalDinilai > 0
            ? round($totalRelevan / $totalDinilai * 100, 1)
            : 0.0;

        return [
            'total_responden' => $totalResponden,
            'total_bekerja' => $totalBekerja,
            'total_dinilai' => $totalDinilai,
            'total_relevan' => $totalRelevan,
            'tingkat_keterserapan' => $tingkatKeterserapan,
            'rata_rata_relevansi' => $rataRataRelevansi,
            'persentase_relevan' => $persentaseRelevan,
            'label_total_responden' => number_format($totalResponden, 0, ',', '.'),
            'label_tingkat_keterserapan' => $this->formatPersen($tingkatKeterserapan),
            'label_rata_rata_relevansi' => number_format($rataRataRelevansi, 2, ',', '.'),
            'label_persentase_relevan' => $this->formatPersen($persentaseRelevan),
        ];
    }

    private function formatPersen(float $nilai): string
    {
        $teks = rtrim(rtrim(number_format($nilai, 1, ',', '.'), '0'), ',');

        return $teks.'%';
    }
}
