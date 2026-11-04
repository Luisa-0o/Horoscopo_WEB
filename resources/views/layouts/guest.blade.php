{{-- Maestra para las páginas públicas (inicio, login, registro) --}}
@extends('layouts.base')

@section('cuerpo')
    <nav class="navbar navbar-expand-lg navbar-dark barra">
        <div class="container">
            <a class="navbar-brand" href="{{ route('inicio') }}">✨ Horóscopo Web</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPublico">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuPublico">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('inicio') }}">Inicio</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Mi panel</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @include('partials.alertas')
        @yield('contenido')
    </main>

    <footer class="text-center text-muted py-3 border-top">
        <small>Horóscopo Web &copy; {{ date('Y') }} · Lecturas de <a href="https://api-ninjas.com/api/horoscope" target="_blank">API Ninjas</a></small>
    </footer>
@endsection
