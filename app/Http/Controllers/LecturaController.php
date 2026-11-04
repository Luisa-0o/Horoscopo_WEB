<?php

namespace App\Http\Controllers;

use App\Models\Lectura;
use App\Models\Signo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// CRUD de la tabla lecturas (solo las del usuario que inició sesión)
class LecturaController extends Controller
{
    public function index()
    {
        $lecturas = Auth::user()->lecturas()->with('signo')->latest('fecha')->get();

        return view('lecturas.index', compact('lecturas'));
    }

    public function create()
    {
        $signos = Signo::orderBy('id')->get();

        return view('lecturas.create', ['lectura' => new Lectura(['fecha' => now()]), 'signos' => $signos]);
    }

    public function store(Request $request)
    {
        $datos = $this->validar($request);
        $datos['user_id'] = Auth::id();

        Lectura::create($datos);

        return redirect()->route('lecturas.index')->with('exito', 'Lectura creada correctamente.');
    }

    public function show(Lectura $lectura)
    {
        $this->verificarDueno($lectura);

        return view('lecturas.show', compact('lectura'));
    }

    public function edit(Lectura $lectura)
    {
        $this->verificarDueno($lectura);
        $signos = Signo::orderBy('id')->get();

        return view('lecturas.edit', compact('lectura', 'signos'));
    }

    public function update(Request $request, Lectura $lectura)
    {
        $this->verificarDueno($lectura);

        $lectura->update($this->validar($request));

        return redirect()->route('lecturas.index')->with('exito', 'Lectura actualizada correctamente.');
    }

    public function destroy(Lectura $lectura)
    {
        $this->verificarDueno($lectura);

        $lectura->delete();

        return redirect()->route('lecturas.index')->with('exito', 'Lectura eliminada.');
    }

    // Descargar una lectura guardada en PDF
    public function pdf(Lectura $lectura)
    {
        $this->verificarDueno($lectura);

        $pdf = Pdf::loadView('pdf.lectura', [
            'signo' => $lectura->signo,
            'fecha' => $lectura->fecha->toDateString(),
            'texto' => $lectura->texto,
            'nota' => $lectura->nota,
            'user' => Auth::user(),
        ]);

        return $pdf->download('lectura-'.$lectura->id.'.pdf');
    }

    private function validar(Request $request): array
    {
        $datos = $request->validate([
            'signo_id' => 'required|exists:signos,id',
            'fecha' => 'required|date|before_or_equal:today',
            'texto' => 'required|string|max:3000',
            'nota' => 'nullable|string|max:255',
        ]);
        $datos['favorita'] = $request->boolean('favorita');

        return $datos;
    }

    // Un usuario no puede ver ni tocar las lecturas de otro
    private function verificarDueno(Lectura $lectura): void
    {
        abort_if($lectura->user_id !== Auth::id(), 403);
    }
}
