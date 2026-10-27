<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login')->name('home');
Route::inertia('/login', 'auth/login')->name('login');

Route::get('/dashboard', fn () => 'dashboard')->name('dashboard');

require __DIR__.'/auth.php';
