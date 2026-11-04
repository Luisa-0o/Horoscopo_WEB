@extends('layouts.guest')

@section('titulo', 'Iniciar sesión')

@section('contenido')
    <div class="card caja-formulario shadow-sm">
        <div class="card-body p-4">
            <h3 class="text-center mb-3">🔮 Iniciar sesión</h3>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="recordarme" id="recordarme" class="form-check-input">
                    <label for="recordarme" class="form-check-label">Recordarme</label>
                </div>

                <button type="submit" class="btn btn-morado w-100">Entrar</button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a><br>
                ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
            </div>
        </div>
    </div>
@endsection
