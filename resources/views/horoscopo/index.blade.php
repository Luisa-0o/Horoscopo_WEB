@extends('layouts.panel')

@section('titulo', 'Horóscopos del día')

@section('contenido')
    <p>Escoge un signo para ver su lectura de hoy.</p>

    <div class="row">
        @foreach ($signos as $signo)
            <div class="col-6 col-md-4 col-lg-3 mb-3">
                <div class="card tarjeta-signo p-3 h-100 {{ auth()->user()->signo_id == $signo->id ? 'border-primary border-2' : '' }}">
                    <a href="{{ route('horoscopo.show', $signo) }}">
                        @if ($signo->imagen)
                            <img src="{{ $signo->imagenUrl() }}" alt="{{ $signo->nombre }}" class="imagen-signo mb-1">
                        @else
                            <div class="simbolo">{{ $signo->simbolo }}</div>
                        @endif
                        <h5 class="mb-0">{{ $signo->nombre }}</h5>
                        <small class="text-muted">{{ $signo->fecha_inicio }} - {{ $signo->fecha_fin }}</small>
                        @if (auth()->user()->signo_id == $signo->id)
                            <div><span class="badge bg-primary">Mi signo</span></div>
                        @endif
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
