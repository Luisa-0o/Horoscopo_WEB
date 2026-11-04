<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Signo;
use App\Services\HoroscopoService;

// Rutas de nuestra API que puede consumir cualquier aplicación externa
class SignoApiController extends Controller
{
    // GET /api/signos
    public function index()
    {
        $signos = Signo::orderBy('id')->get()->map(fn ($s) => $this->formato($s));

        return response()->json(['data' => $signos]);
    }

    // GET /api/signos/{slug}
    public function show(Signo $signo)
    {
        return response()->json(['data' => $this->formato($signo)]);
    }

    // GET /api/horoscopo/{slug}
    public function horoscopo(Signo $signo, HoroscopoService $horoscopo)
    {
        $lectura = $horoscopo->obtener($signo->slug);

        if (! $lectura) {
            return response()->json(['mensaje' => 'No se pudo obtener el horóscopo en este momento.'], 503);
        }

        return response()->json([
            'signo' => $signo->nombre,
            'slug' => $signo->slug,
            'fecha' => $lectura['fecha'],
            'horoscopo' => $lectura['texto'],
            'fuente' => 'api-ninjas.com',
        ]);
    }

    private function formato(Signo $signo): array
    {
        return [
            'id' => $signo->id,
            'nombre' => $signo->nombre,
            'slug' => $signo->slug,
            'simbolo' => $signo->simbolo,
            'fecha_inicio' => $signo->fecha_inicio,
            'fecha_fin' => $signo->fecha_fin,
            'elemento' => $signo->elemento,
            'descripcion' => $signo->descripcion,
            'imagen' => $signo->imagenUrl(),
        ];
    }
}
