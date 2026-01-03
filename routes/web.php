<?php
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\OrderController;

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

// Rutas para la gestión de pedidos (RF-06, RF-08, RF-15)
Route::middleware(['auth'])->group(function () {
    // 1. Crear el pedido desde el mapa de mesas
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');

    // 2. Ver la comanda para añadir productos
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // 3. Lógica para añadir platos y enviar a cocina
    Route::post('/orders/{order}/add', [OrderController::class, 'addProduct'])->name('orders.add-product');
    Route::post('/orders/{order}/send', [OrderController::class, 'sendToKitchen'])->name('orders.send-to-kitchen');

    // 4. Facturación y Cierre (RF-15)
    Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
    Route::post('/orders/{order}/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
});
