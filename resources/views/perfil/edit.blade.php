@extends('layouts.panel')

@section('titulo', 'Editar mi perfil')

@section('contenido')
    <div class="card" style="max-width: 600px;">
        <div class="card-body">
            <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="text-center mb-3">
                    <img src="{{ $user->fotoUrl() }}" alt="foto de perfil" class="foto-perfil">
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Cambiar foto (opcional, máx. 2 MB)</label>
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="signo_id" class="form-label">Mi signo</label>
                    <select name="signo_id" id="signo_id" class="form-select" required>
                        @foreach ($signos as $signo)
                            <option value="{{ $signo->id }}" @selected(old('signo_id', $user->signo_id) == $signo->id)>
                                {{ $signo->simbolo }} {{ $signo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-morado">Guardar cambios</button>
            </form>
        </div>
    </div>
@endsection
