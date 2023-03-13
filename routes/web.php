<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
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
Route::post('/auth/registrar', [AuthController::class, 'registrar']);
Route::post('/auth/login', [AuthController::class, 'login']);

<<<<<<< HEAD
Route::get('/gynkana', [GincanaController::class, 'index']);
Route::post('listar', [GincanaController::class, 'listar']);
=======


//GincanaPlay
Route::get('/gincana/GincanaPlay', [GincanaController::class, 'showGincanaPlay'])->name('gincana.GincanaPlay');
>>>>>>> 6d00fd2733c70ce8395079fcff89a6fc9de880ae
