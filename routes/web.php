<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;

Route::get('/', function () {
    return view('pages.top');
});

Route::middleware('auth')->group(function () {
    Route::get('/verify-pin', [TwoFactorController::class, 'show'])->name('verify.pin');
    Route::post('/verify-pin', [TwoFactorController::class, 'verify'])->name('verify.pin.store');
});

Route::middleware('auth','two_factor')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
