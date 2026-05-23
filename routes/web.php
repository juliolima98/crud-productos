<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\CategoriasController;
use App\Livewire\Productos\ProductoIndex;

/**
 * RUTAS DE LA APLICACIÓN
 * Aquí se registran las URLs de la aplicación y se asocian con controladores o componentes Livewire.
 */

// Ruta principal: Cuando el usuario entra a la raíz de la web ('/'), ejecuta el método 'index' del ProductosController
Route::get('/', [ProductosController::class, 'index']);

// Route::resource genera automáticamente las 7 rutas básicas para un CRUD:
// (index, create, store, show, edit, update, destroy)
Route::resource('productos', ProductosController::class);
Route::resource('categorias', CategoriasController::class);

// Rutas para componentes Livewire:
// En lugar de apuntar a un controlador, se apunta directamente a la clase del componente.
// Livewire automáticamente renderizará este componente dentro del layout principal (por defecto layouts/app.blade.php).
Route::get('/livewire/productos', ProductoIndex::class)->name('livewire.productos.producto-index');



