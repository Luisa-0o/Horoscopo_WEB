@extends('layouts.guest')

@section('titulo', 'Olvidé mi contraseña')

@section('contenido')
    <div class="card caja-formulario shadow-sm">
        <div class="card-body p-4">
            <h3 class="text-center mb-3">🔑 ¿Olvidaste tu contraseña?</h3>
            <p class="text-muted">Escribe tu correo y te enviaremos un enlace para crear una contraseña nueva.</p>

            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>

                <button type="submit" class="btn btn-morado w-100">Enviar enlace</button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}">Volver al inicio de sesión</a>
            </div>
        </div>
    </div>
@endsection
