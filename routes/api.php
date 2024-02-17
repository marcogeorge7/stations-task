<?php

use App\Http\Controllers\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('register',[UserAuthController::class,'register'])->name('auth.register');
Route::post('login',[UserAuthController::class,'login'])->name('auth.login');
Route::post('logout',[UserAuthController::class,'logout'])->name('auth.logout')
    ->middleware('auth:sanctum');


Route::get('trips', [\App\Http\Controllers\TripController::class, 'index'])->name('trip.index');
Route::get('stations', [\App\Http\Controllers\StationController::class, 'index'])->name('station.index');

Route::get('book/available', [\App\Http\Controllers\BookController::class, 'index'])->name('book.index');
Route::post('book/store', [\App\Http\Controllers\BookController::class, 'store'])->name('book.store');
