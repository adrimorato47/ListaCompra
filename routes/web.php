<?php

use App\Http\Controllers\ListaController;
use App\Http\Controllers\SupermercadoController;
use Illuminate\Support\Facades\Route;


Route::delete('/listas/destroy-all', [ListaController::class, 'destroyAll'])
    ->name('listas.destroyAll');

Route::resource('listas', ListaController::class)
    ->only(['index', 'store', 'update', 'destroy']);

Route::resource('supermercados', SupermercadoController::class)
    ->only(['index', 'store', 'update', 'destroy']);

Route::get('/', function () {
    return redirect()->route('listas.index');
});



