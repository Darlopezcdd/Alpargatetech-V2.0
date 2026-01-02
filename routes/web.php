<?php
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MesaController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de Autenticación (RF-01)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta del Dashboard Protegida
// El middleware 'auth' asegura que nadie entre sin loguearse
// Modifica la ruta del dashboard en routes/web.php
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'role:admin'])->name('dashboard');

Route::get('/mesas', [MesaController::class, 'index'])
    ->middleware(['auth', 'role:admin,mesero']) // Ambos roles pueden ver las mesas
    ->name('mesas.index');

Route::get('/cocina', [OrderController::class, 'kitchenIndex'])
    ->middleware(['auth', 'role:cocinero,admin'])
    ->name('kitchen.index');

// Ruta genérica para actualizar estados de pedido
Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])
    ->name('orders.update-status');
