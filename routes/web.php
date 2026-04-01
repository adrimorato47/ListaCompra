<?php

use App\Http\Controllers\ListaController;
use App\Http\Controllers\SupermercadosController;
use Illuminate\Support\Facades\Route;


Route::resource('listas', ListaController::class)
    ->only(['index', 'store', 'update', 'destroy', 'destroyAll']);

Route::resource('supermercados', SupermercadosController::class)
    ->only(['index', 'store', 'update', 'destroy']);

Route::get('/', function () {
    return redirect()->route('listas.index');
});



