<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('auth.admin.dashboard');

});
