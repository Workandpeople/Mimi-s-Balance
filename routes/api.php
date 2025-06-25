<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;

Route::post('/analyze-invoice', [IndexController::class, 'analyzeInvoice']);
Route::post('/invoices', [IndexController::class, 'storeInvoice']);