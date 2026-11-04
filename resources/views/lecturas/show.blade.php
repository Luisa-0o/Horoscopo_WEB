@extends('layouts.panel')

@section('titulo', 'Lectura del '.$lectura->fecha->format('d/m/Y'))

@section('contenido')
    <div class="card">
        <div class="card-body">
            <h4>{{ $lectura->signo->simbolo }} {{ $lectura->signo->nombre }} {!! $lectura->favorita ? '⭐' : '' !!}</h4>
            <p class="texto-lectura">{{ $lectura->texto }}</p>

            @if ($lectura->nota)
                <p><strong>Mi nota:</strong> {{ $lectura->nota }}</p>
            @endif

            <a href="{{ route('lecturas.pdf', $lectura) }}" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Descargar PDF</a>
            <a href="{{ route('lecturas.edit', $lectura) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('lecturas.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
@endsection
