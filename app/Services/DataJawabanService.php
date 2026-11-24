<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DataJawabanService
{
    public function __construct(private readonly FilterJawaban $filter) {}

    public function data(array $filter = []): LengthAwarePaginator
    {
        $query = $this->filter->query($filter);

        if (! empty($filter['q'])) {
            $cari = addcslashes($filter['q'], '\\%_');

            $query->where(function ($q) use ($cari) {
                $q->where('a.nrp', 'ILIKE', "%{$cari}%")
                    ->orWhere('a.nama', 'ILIKE', "%{$cari}%")
                    ->orWhere('j.nama_perusahaan', 'ILIKE', "%{$cari}%");
            });
        }

        return $query
            ->selectRaw('
                j.id_jawaban,
                a.nrp,
                a.nama,
                a.prodi,
                a.tahun_lulus,
                j.status_kerja,
                j.nama_perusahaan,
                j.bidang_pekerjaan,
                j.jabatan,
                j.skala_gaji,
                j.relevansi,
                j.lokasi_kabupaten,
                j.submitted_at
            ')
            ->orderByDesc('j.submitted_at')
            ->orderByDesc('j.id_jawaban')
            ->paginate(25)
            ->withQueryString();
    }
}
