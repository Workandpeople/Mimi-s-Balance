<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/api/factures', [IndexController::class, 'fetchFactures']);
Route::get('/api/factures-mensuelles', [IndexController::class, 'fetchMonthlyFactures']);
Route::resource('cards', \App\Http\Controllers\CardController::class)->only(['store', 'destroy']);