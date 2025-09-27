<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PedidoController;
use Illuminate\Http\Request;
use App\Http\Controllers\ClienteAuthController;

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

// Libro Routes
Route::resource('libros', LibroController::class);
Route::get('/libros/search', [LibroController::class, 'search'])->name('libros.search');
Route::get('/catalogo', [LibroController::class, 'catalogo'])->name('libros.catalogo');

// Pedido Routes
Route::resource('pedidos', PedidoController::class);
Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create');
// ODIO ESTA RUTA AAAAAAA Route::get('/pedidos/luego', [PedidoController::class, 'luego'])->name('pedidos.luego'); ODIO ESTA RUTA AAAAA
Route::post('/pedidos/luego', [PedidoController::class, 'luego'])->name('pedidos.luego');
Route::post('/pedidos/final', [PedidoController::class, 'final'])->name('pedidos.final');

// Cliente Auth Routes
Route::get('/cliente/login', [ClienteAuthController::class, 'showLoginForm'])->name('cliente.login');
Route::post('/cliente/login', [ClienteAuthController::class, 'login']);
Route::post('/cliente/logout', [ClienteAuthController::class, 'logout'])->name('cliente.logout');
Route::get('/cliente/dashboard', [ClienteAuthController::class, 'dashboard'])
    ->name('cliente.dashboard')
    ->middleware('cliente.auth');

// Change default /login route to redirect to cliente login
Route::get('/login', function () {
    return redirect()->route('cliente.login');
})->name('login');

// Add admin/login route for the User login
Route::get('/admin/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('admin.login');


