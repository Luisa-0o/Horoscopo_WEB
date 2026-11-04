@extends('layouts.panel')

@section('titulo', 'Horóscopo de '.$signo->nombre)

@section('contenido')
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                @if ($signo->imagen)
                    <img src="{{ $signo->imagenUrl() }}" alt="{{ $signo->nombre }}" class="imagen-signo me-3">
                @else
                    <span class="simbolo me-3">{{ $signo->simbolo }}</span>
                @endif
                <div>
                    <h3 class="mb-0">{{ $signo->nombre }}</h3>
                    <small class="text-muted">{{ $signo->fecha_inicio }} - {{ $signo->fecha_fin }} · Elemento: {{ $signo->elemento }}</small>
                </div>
            </div>

            @if ($lectura)
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($lectura['fecha'])->format('d/m/Y') }}</p>
                <p class="texto-lectura">{{ $lectura['texto'] }}</p>

                <a href="{{ route('horoscopo.pdf', $signo) }}" class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
                </a>

                @if ($yaGuardada)
                    <button class="btn btn-secondary" disabled><i class="bi bi-check"></i> Ya está en mis lecturas</button>
                @else
                    <form action="{{ route('horoscopo.guardar', $signo) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success"><i class="bi bi-bookmark"></i> Guardar en mis lecturas</button>
                    </form>
                @endif
            @else
                <div class="alert alert-warning">No se pudo obtener el horóscopo en este momento. Intenta más tarde.</div>
            @endif
        </div>
    </div>

    <a href="{{ route('horoscopo.index') }}" class="btn btn-link mt-3">&larr; Ver otros signos</a>
@endsection
