<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('surveyor')->middleware(['auth', 'role:surveyor'])->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'surveyorDashboard'])->name('auth.surveyor.dashboard');

});
