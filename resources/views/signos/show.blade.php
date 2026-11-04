@extends('layouts.panel')

@section('titulo', 'Signo: '.$signo->nombre)

@section('contenido')
    <div class="card" style="max-width: 600px;">
        <div class="card-body">
            <div class="text-center mb-3">
                @if ($signo->imagen)
                    <img src="{{ $signo->imagenUrl() }}" alt="{{ $signo->nombre }}" class="img-fluid rounded" style="max-height: 200px;">
                @else
                    <div class="simbolo" style="font-size: 80px;">{{ $signo->simbolo }}</div>
                @endif
            </div>

            <table class="table">
                <tr><th>Nombre</th><td>{{ $signo->nombre }}</td></tr>
                <tr><th>Nombre en la API</th><td>{{ $signo->slug }}</td></tr>
                <tr><th>Fechas</th><td>{{ $signo->fecha_inicio }} - {{ $signo->fecha_fin }}</td></tr>
                <tr><th>Elemento</th><td>{{ $signo->elemento }}</td></tr>
                <tr><th>Descripción</th><td>{{ $signo->descripcion }}</td></tr>
                <tr><th>Usuarios con este signo</th><td>{{ $signo->users_count }}</td></tr>
                <tr><th>Lecturas guardadas</th><td>{{ $signo->lecturas_count }}</td></tr>
            </table>

            <a href="{{ route('horoscopo.show', $signo) }}" class="btn btn-morado">Ver horóscopo de hoy</a>
            <a href="{{ route('signos.edit', $signo) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('signos.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
@endsection
