@extends('layouts.guest')

@section('titulo', 'Inicio')

@section('contenido')
    <div class="portada mb-5">
        <h1>✨ Horóscopo Web ✨</h1>
        <p class="lead">Lee tu horóscopo de cada día, mira el de otros signos y descárgalo en PDF.</p>
        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">Ir a mi panel</a>
        @else
            <a href="{{ route('register') }}" class="btn btn-light btn-lg me-2">Crear cuenta gratis</a>
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Iniciar sesión</a>
        @endauth
    </div>

    <h3 class="text-center mb-4">¿Qué puedes hacer aquí?</h3>
    <div class="row text-center mb-5">
        <div class="col-md-4 mb-3">
            <div class="card h-100 p-3">
                <i class="bi bi-stars fs-1 text-primary"></i>
                <h5>Tu lectura diaria</h5>
                <p>Cada día una nueva lectura para tu signo.</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100 p-3">
                <i class="bi bi-people fs-1 text-success"></i>
                <h5>Otros signos</h5>
                <p>Revisa el horóscopo de tu familia y amigos.</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100 p-3">
                <i class="bi bi-file-earmark-pdf fs-1 text-danger"></i>
                <h5>Descarga en PDF</h5>
                <p>Guarda la lectura del día en un archivo PDF.</p>
            </div>
        </div>
    </div>

    <h3 class="text-center mb-4">Los 12 signos</h3>
    <div class="row">
        @foreach ($signos as $signo)
            <div class="col-6 col-md-3 col-lg-2 mb-3">
                <div class="card tarjeta-signo p-2 h-100">
                    <div class="simbolo">{{ $signo->simbolo }}</div>
                    <strong>{{ $signo->nombre }}</strong>
                    <small class="text-muted">{{ $signo->fecha_inicio }} - {{ $signo->fecha_fin }}</small>
                </div>
            </div>
        @endforeach
    </div>
@endsection
