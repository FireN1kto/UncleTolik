<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;

Route::get('/', function () { return view('welcome');})->name('welcome');
Route::get('/services', [ServiceController::class, 'ServicesList'])->name('services');
