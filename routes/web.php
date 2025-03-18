<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WatchlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/car/search', [CarController::class, 'search'])->name('car.search');

// Routes gde user mora da bude prijavljen ali i da mu email bude potvrdjen(ali moze da se izloguje) da bi mogao da im pristupi
Route::middleware(['auth'])->group(function () {
    Route::middleware(['verified'])->group(function() {
        Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist.index');
        Route::get('/watchlist/{car}', [WatchlistController::class, 'storeOrDestroy'])->name('watchlist.storeOrDestroy');

        Route::resource('car', CarController::class)->except(['show']);

        Route::get('/car/{car}/images', [CarController::class, 'carImages'])->name('car.images');
        Route::put('/car/{car}/images', [CarController::class, 'updateImages'])->name('car.updateImages');
        Route::post('/car/{car}/images', [CarController::class, 'addImages'])->name('car.addImages');
    });

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});

Route::get('/car/{car}', [CarController::class, 'show'])->name('car.show');

require __DIR__.'/auth.php';
