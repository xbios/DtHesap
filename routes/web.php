<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Firma Selection Routes
    Route::get('/firmas/select', [\App\Http\Controllers\FirmaSelectionController::class, 'index'])->name('firmas.select');
    Route::post('/firmas/select/{id}', [\App\Http\Controllers\FirmaSelectionController::class, 'select'])->name('firmas.select.submit');
});

require __DIR__ . '/auth.php';
