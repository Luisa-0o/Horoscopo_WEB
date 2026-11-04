<?php

use App\Http\Controllers\Api\SignoApiController;
use Illuminate\Support\Facades\Route;

// API pública de Horóscopo Web (máximo 60 peticiones por minuto)
// Ejemplo: http://localhost:8000/api/horoscopo/leo
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/signos', [SignoApiController::class, 'index']);
    Route::get('/signos/{signo:slug}', [SignoApiController::class, 'show']);
    Route::get('/horoscopo/{signo:slug}', [SignoApiController::class, 'horoscopo']);
});
