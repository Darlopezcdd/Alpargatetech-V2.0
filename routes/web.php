<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\Auth\VerifyTwoFactorController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\FixedAssetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

// Raíz → redirige al login
Route::get('/', fn () => redirect()->route('login'));

// ─── Rutas para invitados (no autenticados) ───────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Recuperación de contraseña
    Route::get('/forgot-password',  [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetCode'])->name('password.email');
    Route::get('/verify-code',      [PasswordResetController::class, 'showVerifyForm'])->name('password.verify');
    Route::post('/verify-code',     [PasswordResetController::class, 'verifyCode'])->name('password.check');
    Route::get('/reset-password',   [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password',  [PasswordResetController::class, 'resetPassword'])->name('password.update');
});

// Cerrar sesión (accesible desde cualquier estado)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ─── Verificación 2FA ─────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/verify-2fa',  [VerifyTwoFactorController::class, 'index'])->name('verify-2fa.index');
    Route::post('/verify-2fa', [VerifyTwoFactorController::class, 'store'])->name('verify-2fa.store');
});

// ─── Rutas protegidas (autenticado) ──────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard — solo admin
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:admin')
        ->name('dashboard');

    // Mesas — admin y mesero
    Route::get('/mesas', [MesaController::class, 'index'])
        ->middleware('role:admin,mesero')
        ->name('mesas.index');

    // Panel de cocina — cocinero y admin
    Route::get('/cocina', [OrderController::class, 'kitchenIndex'])
        ->middleware('role:cocinero,admin')
        ->name('kitchen.index');

    // ─── Pedidos ─────────────────────────────────────────────────────────────
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/create',           [OrderController::class, 'create'])->name('create');
        Route::post('/store',           [OrderController::class, 'store'])->name('store');
        Route::get('/{order}',          [OrderController::class, 'show'])->name('show');
        Route::get('/{order}/invoice',  [OrderController::class, 'downloadInvoice'])->name('download-invoice');
        Route::post('/{order}/add',     [OrderController::class, 'addProduct'])->name('add-product');
        Route::post('/{order}/send',    [OrderController::class, 'sendToKitchen'])->name('send-to-kitchen');
        Route::post('/{order}/status',  [OrderController::class, 'updateStatus'])->name('update-status');
        Route::post('/{order}/checkout',[OrderController::class, 'checkout'])->name('checkout');
    });

    // ─── Gestión de Usuarios y Auditoría (admin) ─────────────────────────────
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    });

    // ─── Módulos de Administración bajo /admin/ ───────────────────────────────
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        // Menú: categorías y productos
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('products',   ProductController::class)->except(['show']);

        // Inventario: ingredientes y activos fijos
        Route::resource('ingredients',  IngredientController::class)->except(['show']);
        Route::resource('fixed-assets', FixedAssetController::class)->except(['show'])
            ->parameters(['fixed-assets' => 'fixedAsset']);

        // Clientes
        Route::resource('clients', ClientController::class)->except(['show']);

        // Reportes y análisis de ventas
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    });
});
