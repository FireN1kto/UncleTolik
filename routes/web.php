<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MastersController;

Route::get('/', function () { return view('welcome');})->name('welcome');
Route::get('/services', [ServiceController::class, 'ServicesList'])->name('services');
Route::get('/services/haircuts', [ServiceController::class, 'showHaircuts'])->name('services.haircuts');
Route::get('/masters', [MastersController::class, 'MastersList'])->name('masters');
