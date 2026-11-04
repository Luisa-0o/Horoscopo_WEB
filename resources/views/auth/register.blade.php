@extends('layouts.guest')

@section('titulo', 'Registro')

@section('contenido')
    <div class="card caja-formulario shadow-sm">
        <div class="card-body p-4">
            <h3 class="text-center mb-3">🌙 Crear cuenta</h3>

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label for="signo_id" class="form-label">Tu signo</label>
                    <select name="signo_id" id="signo_id" class="form-select" required>
                        <option value="">-- Selecciona tu signo --</option>
                        @foreach ($signos as $signo)
                            <option value="{{ $signo->id }}" @selected(old('signo_id') == $signo->id)>
                                {{ $signo->simbolo }} {{ $signo->nombre }} ({{ $signo->fecha_inicio }} - {{ $signo->fecha_fin }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <div class="form-text">Mínimo 8 caracteres.</div>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-morado w-100">Registrarme</button>
            </form>

            <div class="text-center mt-3">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
            </div>
        </div>
    </div>
@endsection
