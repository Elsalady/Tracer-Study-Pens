<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataJawabanRequest;
use App\Services\DataJawabanService;
use App\Services\FilterJawaban;
use Illuminate\Contracts\View\View;

class DataJawabanController extends Controller
{
    public function __construct(
        private readonly DataJawabanService $service,
        private readonly FilterJawaban $filter,
    ) {}

    public function index(DataJawabanRequest $request): View
    {
        $filter = $request->validated();

        return view('admin.dashboard.data-jawaban', [
            'jawaban' => $this->service->data($filter),
            'filter' => $filter,
            'opsi' => $this->filter->opsi(),
        ]);
    }
}
