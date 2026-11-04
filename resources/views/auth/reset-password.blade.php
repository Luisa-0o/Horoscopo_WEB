@extends('layouts.guest')

@section('titulo', 'Nueva contraseña')

@section('contenido')
    <div class="card caja-formulario shadow-sm">
        <div class="card-body p-4">
            <h3 class="text-center mb-3">🔒 Crear nueva contraseña</h3>

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $email) }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Nueva contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-morado w-100">Guardar contraseña</button>
            </form>
        </div>
    </div>
@endsection
