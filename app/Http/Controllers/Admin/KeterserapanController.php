<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardFilterRequest;
use App\Services\FilterJawaban;
use App\Services\KeterserapanService;
use Illuminate\Contracts\View\View;

class KeterserapanController extends Controller
{
    public function __construct(
        private readonly KeterserapanService $service,
        private readonly FilterJawaban $filter,
    ) {}

    public function index(DashboardFilterRequest $request): View
    {
        $filter = $request->validated();

        return view('admin.dashboard.keterserapan', [
            'data' => $this->service->data($filter),
            'filter' => $filter,
            'opsi' => $this->filter->opsi(),
        ]);
    }
}
