<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ReportsController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/log', [LogController::class, 'index'])->name('log');
    Route::get('/log/{id}', [LogController::class, 'show']);
    Route::get('/api/alert-stats', [LogController::class, 'getAlertStats'])->name('charts');
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
    Route::get('/reports/export/csv', [ReportsController::class, 'exportCsv'])->name('reports.csv');
    Route::get('/reports/export/pdf', [ReportsController::class, 'exportPdf'])->name('reports.pdf');
});
