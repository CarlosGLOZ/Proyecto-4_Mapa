<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LikeLocalizacionController;
use App\Http\Controllers\LocalizacionController;
use App\Http\Controllers\GincanaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [Controller::class, 'index'])->name('home');

// Auth
Route::get('/auth/LoginRegistrar', [AuthController::class, 'showLoginRegistrar'])->name('auth.LoginRegistrar');
Route::post('/auth/registrar', [AuthController::class, 'registrar'])->name('auth.registrar');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

// Localizaciones
Route::get('/loc/localizaciones', [LocalizacionController::class, 'get'])->name('loc.localizaciones');

//GincanaPlay
Route::get('/gincana/GincanaPlay/{id}', [GincanaController::class, 'showGincanaPlay'])->name('gincana.GincanaPlay');
Route::get('/gincana/find/{id}', [GincanaController::class, 'find'])->name('gincana.find');
//Gincana
Route::get('/gincana',[GincanaController::class,'crearView'])->name('gincana.crearView');

// Likes
Route::post('/loc/liked', [LikeLocalizacionController::class, 'isLiked'])->name('loc.liked');
Route::post('/loc/likeLocalizacion', [LikeLocalizacionController::class, 'store'])->name('loc.likeLocalizacion');
Route::delete('/loc/likeLocalizacion', [LikeLocalizacionController::class, 'destroy'])->name('loc.unlikeLocalizacion');
