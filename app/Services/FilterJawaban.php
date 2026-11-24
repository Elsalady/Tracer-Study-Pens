<?php

namespace App\Services;

use App\Models\Alumni;
use App\Models\JawabanTracer;
use Illuminate\Database\Eloquent\Builder;

class FilterJawaban
{
    public const STATUS = [
        'BEKERJA',
        'KULIAH_LANJUT',
        'WIRAUSAHA',
        'BELUM_BEKERJA',
    ];

    public function query(array $filter = []): Builder
    {
        $query = JawabanTracer::query()
            ->from('jawaban_tracer as j')
            ->join('alumni as a', 'a.nrp', '=', 'j.nrp');

        return $this->apply($query, $filter);
    }

    public function apply(Builder $query, array $filter): Builder
    {
        if (! empty($filter['tahun_lulus'])) {
            $query->where('a.tahun_lulus', $filter['tahun_lulus']);
        }

        if (! empty($filter['prodi'])) {
            $query->where('a.prodi', $filter['prodi']);
        }

        if (! empty($filter['status_kerja'])) {
            $query->where('j.status_kerja', $filter['status_kerja']);
        }

        if (! empty($filter['dari_tanggal'])) {
            $query->whereDate('j.submitted_at', '>=', $filter['dari_tanggal']);
        }

        if (! empty($filter['sampai_tanggal'])) {
            $query->whereDate('j.submitted_at', '<=', $filter['sampai_tanggal']);
        }

        return $query;
    }

    public function opsi(): array
    {
        return [
            'tahun' => Alumni::query()->distinct()->orderBy('tahun_lulus')->pluck('tahun_lulus')->all(),
            'prodi' => Alumni::query()->distinct()->orderBy('prodi')->pluck('prodi')->all(),
            'status' => self::STATUS,
        ];
    }
}
