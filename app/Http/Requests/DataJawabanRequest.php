<?php

namespace App\Http\Requests;

class DataJawabanRequest extends DashboardFilterRequest
{
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'q' => ['nullable', 'string', 'max:150'],
        ];
    }
}
