<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EducationController;

// Guest routes
Route::middleware('guest')->group(function () {

    Route::get('/register', [RegisterController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'store'])
        ->name('register.store');

    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');

});

// Authenticated routes
Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('logout');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    // Education
    Route::get('/education', [EducationController::class, 'index'])
        ->name('education.index');

    Route::post('/education', [EducationController::class, 'store'])
        ->name('education.store');

    Route::put('/education/{id}', [EducationController::class, 'update'])
        ->name('education.update');

    Route::delete('/education/{id}', [EducationController::class, 'destroy'])
        ->name('education.destroy');

});