<?php

namespace App\Http\Controllers;

use App\Models\Signo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// Editar el perfil del usuario que inició sesión
class PerfilController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $signos = Signo::orderBy('id')->get();

        return view('perfil.edit', compact('user', 'signos'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $datos = $request->validate([
            'name' => 'required|string|max:100',
            'signo_id' => 'required|exists:signos,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $datos['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        $user->update($datos);

        return redirect()->route('perfil.edit')->with('exito', 'Perfil actualizado.');
    }
}
