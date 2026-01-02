<?php
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para mostrar el formulario
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Ruta para procesar los datos del formulario
Route::post('/login', [LoginController::class, 'login']);
