<?php

namespace App\Http\Controllers;

use App\Models\Lectura;
use App\Models\Signo;
use App\Services\HoroscopoService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

// Lecturas del día que vienen de la API de API Ninjas
class HoroscopoController extends Controller
{
    public function __construct(private HoroscopoService $horoscopo) {}

    // Lista de los 12 signos para escoger cuál ver
    public function index()
    {
        $signos = Signo::orderBy('id')->get();

        return view('horoscopo.index', compact('signos'));
    }

    // Lectura de hoy de un signo
    public function show(Signo $signo)
    {
        $lectura = $this->horoscopo->obtener($signo->slug);

        $yaGuardada = Lectura::where('user_id', Auth::id())
            ->where('signo_id', $signo->id)
            ->whereDate('fecha', $lectura['fecha'] ?? now()->toDateString())
            ->exists();

        return view('horoscopo.show', compact('signo', 'lectura', 'yaGuardada'));
    }

    // Descargar la lectura del día en PDF
    public function pdf(Signo $signo)
    {
        $lectura = $this->horoscopo->obtener($signo->slug);

        if (! $lectura) {
            return back()->with('error', 'No se pudo obtener el horóscopo, intenta más tarde.');
        }

        $pdf = Pdf::loadView('pdf.lectura', [
            'signo' => $signo,
            'fecha' => $lectura['fecha'],
            'texto' => $lectura['texto'],
            'nota' => null,
            'user' => Auth::user(),
        ]);

        return $pdf->download('horoscopo-'.$signo->slug.'-'.$lectura['fecha'].'.pdf');
    }

    // Guardar la lectura de hoy en "Mis lecturas"
    public function guardar(Signo $signo)
    {
        $lectura = $this->horoscopo->obtener($signo->slug);

        if (! $lectura) {
            return back()->with('error', 'No se pudo obtener el horóscopo, intenta más tarde.');
        }

        Lectura::firstOrCreate(
            ['user_id' => Auth::id(), 'signo_id' => $signo->id, 'fecha' => $lectura['fecha']],
            ['texto' => $lectura['texto']]
        );

        return back()->with('exito', 'Lectura guardada en "Mis lecturas".');
    }
}
