<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Signo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Muestra el formulario de registro
    public function create()
    {
        $signos = Signo::orderBy('id')->get();

        return view('auth.register', compact('signos'));
    }

    // Guarda el nuevo usuario
    public function store(Request $request)
    {
        $datos = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email',
            'signo_id' => 'required|exists:signos,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($datos);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('exito', '¡Bienvenido(a), '.$user->name.'!');
    }
}
