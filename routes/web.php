<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataJawabanController;
use App\Http\Controllers\Admin\KeterserapanController;
use App\Http\Controllers\Admin\ProfilAlumniController;
use App\Http\Controllers\Admin\RelevansiController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->middleware('guest')
    ->name('login');
Route::post('/login', [LoginController::class, 'login'])
    ->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'ringkasan']);

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard/ringkasan', [DashboardController::class, 'ringkasan'])
            ->name('dashboard.ringkasan');
        Route::get('/dashboard/keterserapan', [KeterserapanController::class, 'index'])
            ->name('dashboard.keterserapan');
        Route::get('/dashboard/relevansi', [RelevansiController::class, 'index'])
            ->name('dashboard.relevansi');
        Route::get('/dashboard/profil-alumni', [ProfilAlumniController::class, 'index'])
            ->name('dashboard.profil-alumni');
        Route::get('/dashboard/data-jawaban', [DataJawabanController::class, 'index'])
            ->name('dashboard.data-jawaban');
    });
});
