<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login')->name('home');
Route::inertia('/login', 'auth/login')->name('login');

// Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])
//     ->middleware('auth')
//     ->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/surveyor.php';
require __DIR__.'/resident.php';
