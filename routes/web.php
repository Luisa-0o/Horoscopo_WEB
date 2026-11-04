<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HoroscopoController;
use App\Http\Controllers\LecturaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SignoController;
use App\Models\Signo;
use Illuminate\Support\Facades\Route;

// Landing page (pública)
Route::get('/', function () {
    $signos = Signo::orderBy('id')->get();

    return view('inicio', compact('signos'));
})->name('inicio');

// Solo para visitantes que NO han iniciado sesión
Route::middleware('guest')->group(function () {
    Route::get('/registro', [RegisterController::class, 'create'])->name('register');
    Route::post('/registro', [RegisterController::class, 'store']);

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5,1');

    // Recuperar contraseña
    Route::get('/olvide-contrasena', [PasswordController::class, 'solicitar'])->name('password.request');
    Route::post('/olvide-contrasena', [PasswordController::class, 'enviarEnlace'])->name('password.email');
    Route::get('/restablecer-contrasena/{token}', [PasswordController::class, 'formularioNueva'])->name('password.reset');
    Route::post('/restablecer-contrasena', [PasswordController::class, 'guardarNueva'])->name('password.update');
});

// Solo para usuarios que iniciaron sesión
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Horóscopo del día (API Ninjas)
    Route::get('/horoscopo', [HoroscopoController::class, 'index'])->name('horoscopo.index');
    Route::get('/horoscopo/{signo:slug}', [HoroscopoController::class, 'show'])->name('horoscopo.show');
    Route::get('/horoscopo/{signo:slug}/pdf', [HoroscopoController::class, 'pdf'])->name('horoscopo.pdf');
    Route::post('/horoscopo/{signo:slug}/guardar', [HoroscopoController::class, 'guardar'])->name('horoscopo.guardar');

    // CRUD de signos y de lecturas
    Route::resource('signos', SignoController::class);
    Route::resource('lecturas', LecturaController::class);
    Route::get('/lecturas/{lectura}/pdf', [LecturaController::class, 'pdf'])->name('lecturas.pdf');

    // Perfil del usuario
    Route::get('/perfil', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
});
