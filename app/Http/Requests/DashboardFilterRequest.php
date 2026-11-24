<?php

namespace App\Http\Requests;

use App\Services\FilterJawaban;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DashboardFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tahun_lulus' => ['nullable', 'integer', 'digits:4'],
            'prodi' => ['nullable', 'string', 'max:100'],
            'status_kerja' => ['nullable', Rule::in(FilterJawaban::STATUS)],
            'dari_tanggal' => ['nullable', 'date_format:Y-m-d'],
            'sampai_tanggal' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:dari_tanggal'],
        ];
    }
}
