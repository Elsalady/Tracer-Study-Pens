<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardFilterRequest;
use App\Services\DashboardService;
use App\Services\FilterJawaban;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboard,
        private readonly FilterJawaban $filter,
    ) {}

    public function ringkasan(DashboardFilterRequest $request): View
    {
        $filter = $request->validated();

        return view('admin.dashboard.ringkasan', [
            'kpi' => $this->dashboard->ringkasan($filter),
            'filter' => $filter,
            'opsi' => $this->filter->opsi(),
        ]);
    }
}
