<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class ProfilAlumniService
{
    private const SKALA_GAJI = [
        '<3000000',
        '3000000-5000000',
        '5000000-10000000',
        '>10000000',
    ];

    public function __construct(private readonly FilterJawaban $filter) {}

    public function data(array $filter = []): array
    {
        $kabupaten = $this->kabupaten($filter);

        return [
            'total_bekerja' => (clone $this->queryBekerja($filter))->count(),
            'skala_gaji_label' => self::SKALA_GAJI,
            'bidang' => $this->bidangPekerjaan($filter),
            'skala_gaji' => $this->skalaGaji($filter),
            'kabupaten' => $kabupaten,
            'kabupaten_top' => array_slice($kabupaten, 0, 10),
        ];
    }

    private function queryBekerja(array $filter): Builder
    {
        return $this->filter->query($filter)
            ->where('j.status_kerja', 'BEKERJA');
    }

    private function bidangPekerjaan(array $filter): array
    {
        return $this->queryBekerja($filter)
            ->selectRaw('j.bidang_pekerjaan AS label, COUNT(*) AS jumlah')
            ->groupBy('j.bidang_pekerjaan')
            ->orderByDesc('jumlah')
            ->get()
            ->map(fn ($row) => [
                'label' => (string) $row->label,
                'jumlah' => (int) $row->jumlah,
            ])
            ->all();
    }

    private function skalaGaji(array $filter): array
    {
        $urutan = implode(' ', array_map(
            fn (string $label, int $index) => "WHEN '{$label}' THEN {$index}",
            self::SKALA_GAJI,
            array_map(fn (int $index) => $index + 1, array_keys(self::SKALA_GAJI))
        ));

        return $this->queryBekerja($filter)
            ->selectRaw('j.skala_gaji AS label, COUNT(*) AS jumlah')
            ->groupBy('j.skala_gaji')
            ->orderByRaw("CASE j.skala_gaji {$urutan} END")
            ->get()
            ->map(fn ($row) => [
                'label' => (string) $row->label,
                'jumlah' => (int) $row->jumlah,
            ])
            ->all();
    }

    private function kabupaten(array $filter): array
    {
        return $this->queryBekerja($filter)
            ->selectRaw('j.lokasi_kabupaten AS label, COUNT(*) AS jumlah')
            ->groupBy('j.lokasi_kabupaten')
            ->orderByDesc('jumlah')
            ->orderBy('label')
            ->get()
            ->map(fn ($row) => [
                'label' => (string) $row->label,
                'jumlah' => (int) $row->jumlah,
            ])
            ->all();
    }
}
