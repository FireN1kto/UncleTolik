<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MastersController;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\MasterMiddleware;
use App\Http\Controllers\WorksController;

Route::get('/', function () { return view('welcome');})->name('welcome');
Route::get('/services', [ServiceController::class, 'ServicesList'])->name('services');
Route::get('/services/shaving', [ServiceController::class, 'showShaving'])->name('services.shaving');
Route::get('/services/haircuts', [ServiceController::class, 'showHaircuts'])->name('services.haircuts');
Route::get('/services/facial-treatment', [ServiceController::class, 'showFacialTreatment'])->name('services.facial-treatment');
Route::get('/masters', [MastersController::class, 'MastersList'])->name('masters');
Route::get('/works', [WorksController::class, 'index'])->name('works');

Route::get('/profile/user', [UserProfileController::class, 'index'])->name('profile.user')
    ->middleware([UserMiddleware::class]);
Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit')
    ->middleware([UserMiddleware::class]);
Route::post('/profile/update', [UserProfileController::class, 'update'])->name('profile.update')
    ->middleware([UserMiddleware::class]);

Route::get('/profile/master', [MastersController::class, 'index'])->name('profile.master')
    ->middleware([MasterMiddleware::class]);
Route::post('/profile/master/work', [MastersController::class, 'uploadWork'])->name('profile.master.work.upload')
    ->middleware([MasterMiddleware::class]);
Route::delete('/profile/master/work/{work}', [MastersController::class, 'deleteWork'])->name('profile.master.work.delete')
    ->middleware([MasterMiddleware::class]);
