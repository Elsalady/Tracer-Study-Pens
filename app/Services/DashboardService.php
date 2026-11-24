<?php

namespace App\Services;

class DashboardService
{
    public function __construct(private readonly FilterJawaban $filter) {}

    public function ringkasan(array $filter = []): array
    {
        $base = $this->filter->query($filter);

        $totalResponden = (clone $base)->count();
        $totalBekerja = (clone $base)
            ->where('j.status_kerja', 'BEKERJA')
            ->count();

        $tingkatKeterserapan = $totalResponden > 0
            ? round($totalBekerja / $totalResponden * 100, 1)
            : 0.0;

        $relevansi = (clone $base)
            ->where('j.status_kerja', 'BEKERJA')
            ->whereNotNull('j.relevansi');

        $totalDinilai = (clone $relevansi)->count();
        $rataRata = (clone $relevansi)->avg('j.relevansi');
        $totalRelevan = (clone $relevansi)
            ->where('j.relevansi', '>=', 4)
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
            'tren' => $this->trenKeterserapan($filter),
            'komposisi' => $this->komposisiStatusKerja($filter),
        ];
    }

    private function trenKeterserapan(array $filter): array
    {
        $rows = $this->filter->query($filter)
            ->selectRaw("
                a.tahun_lulus,
                COUNT(*) AS total_responden,
                COUNT(*) FILTER (WHERE j.status_kerja = 'BEKERJA') AS total_bekerja
            ")
            ->groupBy('a.tahun_lulus')
            ->orderBy('a.tahun_lulus')
            ->get();

        return $rows->map(function ($row) {
            $total = (int) $row->total_responden;
            $bekerja = (int) $row->total_bekerja;

            return [
                'tahun_lulus' => (int) $row->tahun_lulus,
                'total_responden' => $total,
                'total_bekerja' => $bekerja,
                'persentase' => $total > 0 ? round($bekerja / $total * 100, 1) : 0.0,
            ];
        })->all();
    }

    private function komposisiStatusKerja(array $filter): array
    {
        $jumlah = $this->filter->query($filter)
            ->selectRaw('j.status_kerja AS status, COUNT(*) AS jumlah')
            ->groupBy('j.status_kerja')
            ->pluck('jumlah', 'status')
            ->all();

        return array_map(fn (string $status) => [
            'status' => $status,
            'jumlah' => (int) ($jumlah[$status] ?? 0),
        ], FilterJawaban::STATUS);
    }

    private function formatPersen(float $nilai): string
    {
        $teks = rtrim(rtrim(number_format($nilai, 1, ',', '.'), '0'), ',');

        return $teks.'%';
    }
}
