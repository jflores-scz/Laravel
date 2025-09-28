<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\DeudaController;
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

// Pedido Routes (Original - commented out for Prestamo Admin)
// Route::resource('pedidos', PedidoController::class);
// Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create');
// Route::post('/pedidos/luego', [PedidoController::class, 'luego'])->name('pedidos.luego');
// Route::post('/pedidos/final', [PedidoController::class, 'final'])->name('pedidos.final');

// Prestamo Admin Routes (repurposing Pedidos section)
Route::get('/pedidos', [PrestamoController::class, 'adminIndex'])->name('pedidos.index')->middleware('auth');
Route::get('/pedidos/{prestamo}', [PrestamoController::class, 'adminShow'])->name('pedidos.show')->middleware('auth');
Route::post('/pedidos/{prestamo}/approve', [PrestamoController::class, 'approve'])->name('pedidos.approve')->middleware('auth');
Route::post('/pedidos/{prestamo}/admin-cancel', [PrestamoController::class, 'adminCancel'])->name('pedidos.admin_cancel')->middleware('auth');

// Prestamo Routes
Route::resource('prestamos', PrestamoController::class)->except(['show']);
Route::get('prestamos/create/{libro}', [PrestamoController::class, 'create'])->name('prestamos.create');
Route::get('/prestamos', [PrestamoController::class, 'index'])->name('prestamos.index')->middleware('cliente.auth');
Route::delete('/prestamos/{prestamo}/cancel', [PrestamoController::class, 'cancel'])->name('prestamos.cancel')->middleware('cliente.auth');

// Prestamo Returns Management Routes (Admin)
Route::get('/prestamos/returns', [PrestamoController::class, 'returnsIndex'])->name('prestamos.returns.index')->middleware('auth');
Route::post('/prestamos/{prestamo}/return', [PrestamoController::class, 'markAsReturned'])->name('prestamos.return')->middleware('auth');

// Prestamo Admin Creation Routes
Route::get('/prestamos/admin/create/{libro}', [PrestamoController::class, 'adminCreateForm'])->name('prestamos.admin_create_form')->middleware('auth');
Route::post('/prestamos/admin/confirm', [PrestamoController::class, 'adminCreateConfirm'])->name('prestamos.admin_create_confirm')->middleware('auth');
Route::post('/prestamos/admin/store', [PrestamoController::class, 'adminStore'])->name('prestamos.admin_store')->middleware('auth');

// Deudas Routes (Client)
Route::get('/deudas', [DeudaController::class, 'index'])->name('deudas.index')->middleware('cliente.auth');

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


