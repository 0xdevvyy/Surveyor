<?php

use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');
Route::inertia('/login', 'login')->name('login');

require __DIR__.'/auth.php';
