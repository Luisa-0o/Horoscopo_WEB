{{-- Maestra para las páginas que requieren iniciar sesión --}}
@extends('layouts.base')

@section('cuerpo')
    <nav class="navbar navbar-dark barra">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">✨ Horóscopo Web</a>
            <span class="navbar-text text-white">
                <img src="{{ auth()->user()->fotoUrl() }}" alt="foto" class="foto-mini me-1">
                Hola, <strong>{{ auth()->user()->name }}</strong>
            </span>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Menú lateral -->
            <aside class="col-md-3 col-lg-2 menu-lateral py-3">
                <div class="text-center mb-3">
                    <img src="{{ auth()->user()->fotoUrl() }}" alt="foto de perfil" class="foto-perfil mb-2">
                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                    <small class="text-muted">{{ auth()->user()->email }}</small><br>
                    @if (auth()->user()->signo)
                        <span class="badge bg-morado mt-1">{{ auth()->user()->signo->simbolo }} {{ auth()->user()->signo->nombre }}</span>
                    @endif
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'activo' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-house"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('horoscopo.*') ? 'activo' : '' }}" href="{{ route('horoscopo.index') }}">
                            <i class="bi bi-stars"></i> Horóscopos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lecturas.*') ? 'activo' : '' }}" href="{{ route('lecturas.index') }}">
                            <i class="bi bi-journal-text"></i> Listar mis lecturas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('signos.*') ? 'activo' : '' }}" href="{{ route('signos.index') }}">
                            <i class="bi bi-list-ul"></i> Listar signos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('perfil.*') ? 'activo' : '' }}" href="{{ route('perfil.edit') }}">
                            <i class="bi bi-person-gear"></i> Editar perfil
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link text-danger border-0 bg-transparent">
                                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </aside>

            <!-- Contenido de cada página -->
            <main class="col-md-9 col-lg-10 py-4">
                <h2 class="mb-3">@yield('titulo')</h2>
                @include('partials.alertas')
                @yield('contenido')
            </main>
        </div>
    </div>
@endsection
