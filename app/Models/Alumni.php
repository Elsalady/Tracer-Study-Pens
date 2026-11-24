<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Alumni extends Model
{
    protected $table = 'alumni';

    protected $primaryKey = 'nrp';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'nrp',
        'nama',
        'prodi',
        'tahun_lulus',
        'email',
    ];

    protected function casts(): array
    {
        return [
            'tahun_lulus' => 'integer',
        ];
    }

    public function jawabanTracer(): HasOne
    {
        return $this->hasOne(JawabanTracer::class, 'nrp', 'nrp');
    }
}
