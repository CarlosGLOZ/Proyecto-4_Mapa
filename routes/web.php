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


//Gincana
Route::get('/gincana',[GincanaController::class,'crearView'])->name('gincana.crearView');

Route::get('/createGincana', [GincanaController::class, 'index']);
Route::get('/createGincana2/{gincana}', [GincanaController::class, 'index2']);
Route::post('listar', [GincanaController::class, 'listar']);
Route::post('/createGincana2/savePista', [GincanaController::class, 'savePista'])->name('gincana.savepista');
Route::post('/saveGin', [GincanaController::class, 'saveGin'])->name('gincana.saveGin');
Route::post('/createGincana2/getLocaFromPoint', [GincanaController::class, 'getLocaFromPoint'])->name('gincana.getLocaFromPoint');
Route::post('/createGincana2/PointComplete', [GincanaController::class, 'pointComplete'])->name('gincana.pointComplete');
Route::post('/createGincana2/deletePista', [GincanaController::class, 'deletePista'])->name('gincana.deletePista');
