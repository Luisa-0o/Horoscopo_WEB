<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

// Recuperar la contraseña ("¿Olvidaste tu contraseña?")
class PasswordController extends Controller
{
    // Formulario para pedir el enlace
    public function solicitar()
    {
        return view('auth.forgot-password');
    }

    // Envía el correo con el enlace
    public function enviarEnlace(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $estado = Password::sendResetLink($request->only('email'));

        if ($estado === Password::RESET_LINK_SENT) {
            return back()->with('exito', __($estado));
        }

        return back()->withErrors(['email' => __($estado)])->onlyInput('email');
    }

    // Formulario para escribir la nueva contraseña
    public function formularioNueva(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    // Guarda la nueva contraseña
    public function guardarNueva(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $estado = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = $password;
                $user->save();
            }
        );

        if ($estado === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('exito', __($estado));
        }

        return back()->withErrors(['email' => __($estado)])->onlyInput('email');
    }
}
