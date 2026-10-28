<?php

use App\Http\Controllers\Auth\SessionsController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [SessionsController::class, 'login'])->name('index.auth');
Route::post('/login', [SessionsController::class, 'storeSession'])->name('auth.store');
