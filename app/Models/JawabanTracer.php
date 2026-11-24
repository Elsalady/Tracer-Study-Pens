<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JawabanTracer extends Model
{
    protected $table = 'jawaban_tracer';

    protected $primaryKey = 'id_jawaban';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'nrp',
        'status_kerja',
        'nama_perusahaan',
        'bidang_pekerjaan',
        'jabatan',
        'tanggal_mulai',
        'skala_gaji',
        'relevansi',
        'lokasi_kabupaten',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'relevansi' => 'integer',
            'tanggal_mulai' => 'date',
            'submitted_at' => 'datetime',
        ];
    }

    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class, 'nrp', 'nrp');
    }
}
