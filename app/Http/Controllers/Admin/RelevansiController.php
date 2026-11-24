<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardFilterRequest;
use App\Services\FilterJawaban;
use App\Services\RelevansiService;
use Illuminate\Contracts\View\View;

class RelevansiController extends Controller
{
    public function __construct(
        private readonly RelevansiService $service,
        private readonly FilterJawaban $filter,
    ) {}

    public function index(DashboardFilterRequest $request): View
    {
        $filter = $request->validated();

        return view('admin.dashboard.relevansi', [
            'data' => $this->service->data($filter),
            'filter' => $filter,
            'opsi' => $this->filter->opsi(),
        ]);
    }
}
