<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LikeLocalizacionController;
use App\Http\Controllers\LocalizacionController;
use App\Http\Controllers\GincanaController;
use App\Http\Controllers\SalaGincanaController;
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
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Localizaciones
Route::get('/loc/localizaciones', [LocalizacionController::class, 'get'])->name('loc.localizaciones');
Route::get('/loc/favoritas', [LocalizacionController::class, 'favoritas'])->name('loc.favoritas');
Route::get('/loc/asyncFavoritas', [LocalizacionController::class, 'asyncFavoritas'])->name('loc.asyncFavoritas');
Route::post('/loc/find', [LocalizacionController::class, 'find'])->name('loc.find');

//Gincana
Route::get('/gincana/crear',[GincanaController::class,'crearView'])->name('gincana.crearView');
Route::get('/gincana/lista', [GincanaController::class, 'lista'])->name('gincana.lista');
Route::post('/gincana/filtrar', [GincanaController::class, 'fitrar'])->name('gincana.filtrar');
Route::get('/gincana/{id}', [GincanaController::class, 'view'])->name('gincana.view');
Route::get('/gincana/find/{id}', [GincanaController::class, 'find'])->name('gincana.find');

Route::get('/createGincana', [GincanaController::class, 'index'])->name('gincana.crear');;
Route::post('/createGincana2', [GincanaController::class, 'saveGin2'])->name('gincana.store');
Route::post('/editarGincana', [GincanaController::class, 'index2'])->name('gincana.editar');
Route::delete('/gincana/borrar/{gincana}', [GincanaController::class, 'deleteGin'])->name('gincana.delete');
Route::post('listar', [GincanaController::class, 'listar']);
Route::post('/createGincana2/savePista', [GincanaController::class, 'savePista'])->name('gincana.savepista');
// Route::post('/saveGin', [GincanaController::class, 'saveGin'])->name('gincana.saveGin');
Route::post('/createGincana2/getLocaFromPoint', [GincanaController::class, 'getLocaFromPoint'])->name('gincana.getLocaFromPoint');
Route::post('/createGincana2/PointComplete', [GincanaController::class, 'pointComplete'])->name('gincana.pointComplete');
Route::post('/createGincana2/deletePista', [GincanaController::class, 'deletePista'])->name('gincana.deletePista');

// Sala
Route::get('/sala/{id}', [SalaGincanaController::class, 'view'])->name('sala.view');
Route::post('/sala/estado/{sala}', [SalaGincanaController::class, 'estado'])->name('sala.estado');
Route::get('/sala/jugar/{id}', [SalaGincanaController::class, 'jugar'])->name('sala.jugar'); // ANTERIORMENTE GincanaPlay
Route::post('/sala/acceso/{sala}', [SalaGincanaController::class, 'acceso'])->name('sala.acceso');
Route::post('/sala/store', [SalaGincanaController::class, 'store'])->name('sala.store');

// Likes
Route::post('/loc/liked', [LikeLocalizacionController::class, 'isLiked'])->name('loc.liked');
Route::post('/loc/likeLocalizacion', [LikeLocalizacionController::class, 'store'])->name('loc.likeLocalizacion');
Route::delete('/loc/likeLocalizacion', [LikeLocalizacionController::class, 'destroy'])->name('loc.unlikeLocalizacion');
