<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\PedidoController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Cliente Routes
Route::resource('clientes', ClienteController::class);
Route::get('/clientes/search', [ClienteController::class, 'search'])->name('clientes.search');

// Almacen Routes
Route::resource('almacenes', AlmacenController::class);
Route::get('/almacenes/search', [AlmacenController::class, 'search'])->name('almacenes.search');

// Pedido Routes
Route::resource('pedidos', PedidoController::class);
Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create');
// ODIO ESTA RUTA AAAAAAA Route::get('/pedidos/luego', [PedidoController::class, 'luego'])->name('pedidos.luego'); ODIO ESTA RUTA AAAAA
Route::post('/pedidos/luego', [PedidoController::class, 'luego'])->name('pedidos.luego');
Route::post('/pedidos/final', [PedidoController::class, 'final'])->name('pedidos.final');
