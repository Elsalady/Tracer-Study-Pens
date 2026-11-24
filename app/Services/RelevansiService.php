<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class RelevansiService
{
    private const MIN_RESPONDEN = 3;

    public function __construct(private readonly FilterJawaban $filter) {}

    public function data(array $filter = []): array
    {
        $bidang = $this->bidangSkor($filter);
        $distribusi = $this->distribusiSkor($filter);
        $total = array_sum(array_column($distribusi, 'jumlah'));
        $jumlahSkor = array_sum(array_map(fn ($row) => $row['skor'] * $row['jumlah'], $distribusi));
        $relevan = array_sum(array_map(fn ($row) => $row['skor'] >= 4 ? $row['jumlah'] : 0, $distribusi));

        return [
            'total_dinilai' => $total,
            'rata_rata' => $total > 0 ? round($jumlahSkor / $total, 2) : 0.0,
            'persentase_relevan' => $total > 0 ? round($relevan / $total * 100, 1) : 0.0,
            'distribusi' => $distribusi,
            'per_prodi' => $this->rataPerProdi($filter),
            'bidang_terbaik' => $bidang['terbaik'],
            'bidang_terendah' => $bidang['terendah'],
            'minimum_responden' => self::MIN_RESPONDEN,
        ];
    }

    private function queryRelevansi(array $filter): Builder
    {
        return $this->filter->query($filter)
            ->where('j.status_kerja', 'BEKERJA')
            ->whereNotNull('j.relevansi');
    }

    private function distribusiSkor(array $filter): array
    {
        $jumlah = $this->queryRelevansi($filter)
            ->selectRaw('j.relevansi AS skor, COUNT(*) AS jumlah')
            ->groupBy('j.relevansi')
            ->pluck('jumlah', 'skor')
            ->all();

        return array_map(fn (int $skor) => [
            'skor' => $skor,
            'jumlah' => (int) ($jumlah[$skor] ?? 0),
        ], range(1, 5));
    }

    private function rataPerProdi(array $filter): array
    {
        return $this->queryRelevansi($filter)
            ->selectRaw('
                a.prodi,
                COUNT(j.relevansi) AS total_dinilai,
                ROUND(AVG(j.relevansi), 2) AS rata_rata
            ')
            ->groupBy('a.prodi')
            ->orderByDesc('rata_rata')
            ->get()
            ->map(fn ($row) => [
                'prodi' => (string) $row->prodi,
                'total_dinilai' => (int) $row->total_dinilai,
                'rata_rata' => (float) $row->rata_rata,
            ])
            ->all();
    }

    private function bidangSkor(array $filter): array
    {
        $rows = $this->queryRelevansi($filter)
            ->selectRaw('
                j.bidang_pekerjaan AS bidang,
                COUNT(*) AS total_dinilai,
                ROUND(AVG(j.relevansi), 2) AS rata_rata
            ')
            ->groupBy('j.bidang_pekerjaan')
            ->havingRaw('COUNT(*) >= ?', [self::MIN_RESPONDEN])
            ->orderByDesc('rata_rata')
            ->orderBy('bidang')
            ->get()
            ->map(fn ($row) => [
                'bidang' => (string) $row->bidang,
                'total_dinilai' => (int) $row->total_dinilai,
                'rata_rata' => (float) $row->rata_rata,
            ])
            ->all();

        $batas = min(5, intdiv(count($rows), 2));

        return [
            'terbaik' => array_slice($rows, 0, $batas),
            'terendah' => array_reverse(array_slice($rows, count($rows) - $batas, $batas)),
        ];
    }
}
