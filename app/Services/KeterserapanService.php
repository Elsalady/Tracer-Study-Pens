<?php

namespace App\Services;

class KeterserapanService
{
    public function __construct(private readonly FilterJawaban $filter) {}

    public function data(array $filter = []): array
    {
        $base = $this->filter->query($filter);

        $totalResponden = (clone $base)->count();
        $totalBekerja = (clone $base)
            ->where('j.status_kerja', 'BEKERJA')
            ->count();

        $perProdi = $this->filter->query($filter)
            ->selectRaw("
                a.prodi,
                COUNT(*) AS total_responden,
                COUNT(*) FILTER (WHERE j.status_kerja = 'BEKERJA') AS total_bekerja,
                ROUND(
                    100.0 * COUNT(*) FILTER (WHERE j.status_kerja = 'BEKERJA') / COUNT(*),
                    1
                ) AS persentase
            ")
            ->groupBy('a.prodi')
            ->orderByDesc('persentase')
            ->get()
            ->map(fn ($row) => [
                'prodi' => (string) $row->prodi,
                'total_responden' => (int) $row->total_responden,
                'total_bekerja' => (int) $row->total_bekerja,
                'persentase' => (float) $row->persentase,
            ])
            ->all();

        $persentase = $totalResponden > 0
            ? round($totalBekerja / $totalResponden * 100, 1)
            : 0.0;

        return [
            'total_responden' => $totalResponden,
            'total_bekerja' => $totalBekerja,
            'persentase' => $persentase,
            'label_persentase' => rtrim(rtrim(number_format($persentase, 1, ',', '.'), '0'), ',').'%',
            'per_prodi' => $perProdi,
        ];
    }
}
