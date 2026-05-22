<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\CategoriasController;

Route::get('/', [ProductosController::class, 'index']);

Route::resource('productos', ProductosController::class);
Route::resource('categorias', CategoriasController::class);