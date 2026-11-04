<?php

namespace App\Http\Controllers;

use App\Models\Signo;
use App\Models\User;
use App\Services\HoroscopoService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(HoroscopoService $horoscopo)
    {
        $user = Auth::user()->load('signo');

        // Horóscopo de hoy del signo del usuario
        $lecturaHoy = $user->signo ? $horoscopo->obtener($user->signo->slug) : null;

        // Datos para las gráficas
        $signos = Signo::withCount(['users', 'lecturas' => fn ($q) => $q->where('user_id', $user->id)])
            ->orderBy('id')
            ->get();

        $grafica = [
            'etiquetas' => $signos->pluck('nombre'),
            'usuarios' => $signos->pluck('users_count'),
            'lecturas' => $signos->pluck('lecturas_count'),
        ];

        $totales = [
            'lecturas' => $user->lecturas()->count(),
            'favoritas' => $user->lecturas()->where('favorita', true)->count(),
            'usuarios' => User::count(),
        ];

        return view('dashboard', compact('user', 'lecturaHoy', 'grafica', 'totales'));
    }
}
