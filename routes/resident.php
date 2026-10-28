<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('resident')->middleware(['auth', 'role:resident'])->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'residentDashboard'])->name('auth.resident.dashboard');

});
