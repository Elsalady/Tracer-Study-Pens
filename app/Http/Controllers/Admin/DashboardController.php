<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardService $dashboard) {}

    public function ringkasan(): View
    {
        return view('admin.dashboard.ringkasan', [
            'kpi' => $this->dashboard->ringkasan(),
        ]);
    }
}
