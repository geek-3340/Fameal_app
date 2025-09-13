<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\DishesController;
use App\Http\Controllers\MenusController;

Route::get('/', function () {
    return view('top-page');
})->name('top.page');

Route::middleware('auth')->group(function () {
    Route::get('/verify-pin', [TwoFactorController::class, 'show'])->name('verify.pin');
    Route::post('/verify-pin', [TwoFactorController::class, 'verify'])->name('verify.pin.store');
    Route::post('/verify-pin/regenerate', [TwoFactorController::class, 'regenerate'])->name('verify.pin.regenerate');
});

Route::middleware('auth', 'two_factor')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'two_factor')->group(function () {
    Route::get('/menus/meal/month',[MenusController::class, 'index'])->name('menus.meal.month.index');
    Route::get('/menus/meal/week',[MenusController::class, 'index'])->name('menus.meal.week.index');
    Route::get('/menus/baby-food/month',[MenusController::class, 'index'])->name('menus.baby.food.month.index');
    Route::get('/menus/baby-food/week',[MenusController::class, 'index'])->name('menus.baby.food.week.index');

    Route::get('/dishes', [DishesController::class, 'index'])->name('dishes.index');
    Route::post('/dishes', [DishesController::class, 'store'])->name('dishes.store');
});

require __DIR__ . '/auth.php';
