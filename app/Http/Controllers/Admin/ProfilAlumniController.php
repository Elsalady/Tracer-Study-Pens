<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardFilterRequest;
use App\Services\FilterJawaban;
use App\Services\ProfilAlumniService;
use Illuminate\Contracts\View\View;

class ProfilAlumniController extends Controller
{
    public function __construct(
        private readonly ProfilAlumniService $service,
        private readonly FilterJawaban $filter,
    ) {}

    public function index(DashboardFilterRequest $request): View
    {
        $filter = $request->validated();

        return view('admin.dashboard.profil-alumni', [
            'data' => $this->service->data($filter),
            'filter' => $filter,
            'opsi' => $this->filter->opsi(),
        ]);
    }
}
