<?php

namespace App\Http\Controllers;

use App\Models\Signo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

// CRUD de la tabla signos
class SignoController extends Controller
{
    public function index()
    {
        $signos = Signo::withCount('users')->orderBy('id')->get();

        return view('signos.index', compact('signos'));
    }

    public function create()
    {
        return view('signos.create', ['signo' => new Signo]);
    }

    public function store(Request $request)
    {
        $datos = $this->validar($request);

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('signos', 'public');
        }

        Signo::create($datos);

        return redirect()->route('signos.index')->with('exito', 'Signo creado correctamente.');
    }

    public function show(Signo $signo)
    {
        $signo->loadCount(['users', 'lecturas']);

        return view('signos.show', compact('signo'));
    }

    public function edit(Signo $signo)
    {
        return view('signos.edit', compact('signo'));
    }

    public function update(Request $request, Signo $signo)
    {
        $datos = $this->validar($request, $signo);

        if ($request->hasFile('imagen')) {
            // borramos la imagen anterior si había
            if ($signo->imagen) {
                Storage::disk('public')->delete($signo->imagen);
            }
            $datos['imagen'] = $request->file('imagen')->store('signos', 'public');
        }

        $signo->update($datos);

        return redirect()->route('signos.index')->with('exito', 'Signo actualizado correctamente.');
    }

    public function destroy(Signo $signo)
    {
        if ($signo->imagen) {
            Storage::disk('public')->delete($signo->imagen);
        }

        $signo->delete();

        return redirect()->route('signos.index')->with('exito', 'Signo eliminado.');
    }

    private function validar(Request $request, ?Signo $signo = null): array
    {
        return $request->validate([
            'nombre' => 'required|string|max:50',
            // el slug debe ser uno de los que acepta la API
            'slug' => [
                'required',
                Rule::in(['aries', 'taurus', 'gemini', 'cancer', 'leo', 'virgo', 'libra', 'scorpio', 'sagittarius', 'capricorn', 'aquarius', 'pisces']),
                Rule::unique('signos', 'slug')->ignore($signo?->id),
            ],
            'simbolo' => 'nullable|string|max:10',
            'fecha_inicio' => 'required|string|max:30',
            'fecha_fin' => 'required|string|max:30',
            'elemento' => 'required|in:Fuego,Tierra,Aire,Agua',
            'descripcion' => 'nullable|string|max:500',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
    }
}
