<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\DishesController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\MenusDishesController;
use App\Http\Controllers\BabyfoodsController;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\ShoppingListController;

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

    Route::get('/menus/{category}/{viewType}', [MenusController::class, 'index'])
        ->where(['category' => 'dishes|babyfoods', 'viewType' => 'month|week'])
        ->name('menus.index');
    Route::get('/menus/{date}',[MenusController::class,'edit'])->name('menus.edit');

    Route::post('/menus-dishes', [MenusDishesController::class, 'store'])->name('menus.dishes.store');
    Route::delete('/menus-dishes/{id}', [MenusDishesController::class, 'destroy'])->name('menus.dishes.destroy');

    Route::get('/dishes', [DishesController::class, 'index'])->name('dishes.index');
    Route::post('/dishes', [DishesController::class, 'store'])->name('dishes.store');
    Route::get('/dishes/{id}', [DishesController::class, 'edit'])->name('dish.edit');
    Route::put('/dishes/{id}', [DishesController::class, 'update'])->name('dishes.update');
    Route::delete('/dishes/{dish}', [DishesController::class, 'destroy'])->name('dishes.destroy');

    Route::post('/ingredients', [IngredientsController::class, 'store'])->name('ingredients.store');
    Route::delete('/ingredients/{id}', [IngredientsController::class, 'destroy'])->name('ingredients.destroy');

    Route::get('/babyfoods', [BabyfoodsController::class, 'index'])->name('babyfoods.index');
    Route::post('/babyfoods', [BabyfoodsController::class, 'store'])->name('babyfoods.store');
    Route::delete('/babyfoods/{babyfood}', [BabyfoodsController::class, 'destroy'])->name('babyfoods.destroy');

    Route::get('/shopping-list', [ShoppingListController::class, 'index'])->name('shopping.list.index');
    Route::post('/shopping-list', [ShoppingListController::class, 'store'])->name('shopping.list.store');
    Route::post('/shopping-list/ingredients', [ShoppingListController::class, 'ingredientsStore'])->name('shopping.list.ingredients.store');
    Route::post('/shopping-list/{id}/check-toggle', [ShoppingListController::class, 'checkBoxToggle']);
    Route::delete('/shopping-list/destroy', [ShoppingListController::class, 'destroy'])->name('shopping.list.destroy');
});

require __DIR__ . '/auth.php';
