<?php
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

// DEBUG: Route to catch WebSocket requests that aren't proxied by Nginx
Route::any('/app/{any}', function ($any) {
    return "DEBUG: HIT LARAVEL ROUTER for /app/" . $any;
})->where('any', '.*');

// Rutas de Autenticación (RF-01)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas de Recuperación de Contraseña
Route::get('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'sendResetCode'])->name('password.email');
Route::get('/verify-code', [App\Http\Controllers\PasswordResetController::class, 'showVerifyForm'])->name('password.verify');
Route::post('/verify-code', [App\Http\Controllers\PasswordResetController::class, 'verifyCode'])->name('password.check');
Route::get('/reset-password', [App\Http\Controllers\PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\PasswordResetController::class, 'resetPassword'])->name('password.update');

// Ruta del Dashboard Protegida
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('dashboard');

Route::resource('users', \App\Http\Controllers\UserController::class)
    ->middleware(['auth', 'role:admin']);

Route::get('/audit-logs', [\App\Http\Controllers\AuditLogController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('audit-logs.index');

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
// El botón del mapa ahora es GET, solo para ver el menú
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');

    // Este es el que procesa la operación Maestro-Detalle con Rollback
    Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
    // 2. Ver la comanda para añadir productos
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // DESCARGAR FACTURA
    Route::get('/orders/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('orders.download-invoice');

    // 3. Lógica para añadir platos y enviar a cocina
    Route::post('/orders/{order}/add', [OrderController::class, 'addProduct'])->name('orders.add-product');
    Route::post('/orders/{order}/send', [OrderController::class, 'sendToKitchen'])->name('orders.send-to-kitchen');

    // 4. Facturación y Cierre (RF-15)
    Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
    Route::post('/orders/{order}/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');


    // Rutas de 2FA (Añadir después de las rutas de login)
    Route::middleware(['auth'])->group(function () {
        Route::get('/verify-2fa', [App\Http\Controllers\Auth\VerifyTwoFactorController::class, 'index'])->name('verify-2fa.index');
        Route::post('/verify-2fa', [App\Http\Controllers\Auth\VerifyTwoFactorController::class, 'store'])->name('verify-2fa.store');
    });

});
