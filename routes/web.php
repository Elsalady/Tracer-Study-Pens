<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'ringkasan']);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard/ringkasan', [DashboardController::class, 'ringkasan'])
        ->name('dashboard.ringkasan');
});
