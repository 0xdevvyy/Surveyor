<?php

use App\Http\Controllers\PersonalInformationController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login')->name('home');
Route::inertia('/login', 'auth/login')->name('login');
Route::get('/users/{user}/personal-information', [PersonalInformationController::class, 'show'])
    ->middleware('auth')
    ->name('users.personal-information.show');
Route::get('/personal-information/{personalInformation}/edit', [PersonalInformationController::class, 'edit'])
    ->middleware('auth')
    ->name('users.personal-information.edit');
Route::put('/personal-information/{personalInformation}', [PersonalInformationController::class, 'update'])
    ->middleware('auth')
    ->name('users.personal-information.update');

// Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])
//     ->middleware('auth')
//     ->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/surveyor.php';
require __DIR__.'/resident.php';
