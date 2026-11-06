<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('auth.admin.dashboard');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('auth.admin.users.destroy');
    Route::get('/users', [UserController::class, 'index'])->name('auth.admin.users.index');
});
