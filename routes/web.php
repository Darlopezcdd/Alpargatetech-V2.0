<?php
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de Autenticación (RF-01)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta del Dashboard Protegida
// El middleware 'auth' asegura que nadie entre sin loguearse
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
