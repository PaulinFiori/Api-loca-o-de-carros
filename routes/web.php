<?php

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

Route::get('/', function () {
    return view('welcome');
});

//Route::resource('cliente', App\Http\Controllers\ClienteController::class);
//Route::resource('carro', App\Http\Controllers\CarroController::class);
//Route::resource('cliente', App\Http\Controllers\ClienteController::class);
//Route::resource('locacao', App\Http\Controllers\LocacaoController::class);
//Route::resource('marca', App\Http\Controllers\MarcaController::class);
//Route::resource('modelo', App\Http\Controllers\ModeloController::class);
