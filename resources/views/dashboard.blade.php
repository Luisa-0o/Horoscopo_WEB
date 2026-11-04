@extends('layouts.panel')

@section('titulo', 'Mi panel')

@section('contenido')
    <p class="text-muted">Bienvenido(a), <strong>{{ $user->name }}</strong>. Hoy es {{ now()->translatedFormat('l j \d\e F \d\e Y') }}.</p>

    <!-- Horóscopo de hoy -->
    <div class="card mb-4">
        <div class="card-header bg-morado text-white">
            <i class="bi bi-stars"></i> Tu horóscopo de hoy
        </div>
        <div class="card-body">
            @if (! $user->signo)
                <p>Aún no has escogido tu signo. <a href="{{ route('perfil.edit') }}">Escógelo en tu perfil</a>.</p>
            @elseif (! $lecturaHoy)
                <p class="text-danger mb-0">No se pudo cargar el horóscopo en este momento. Revisa la clave de la API o intenta más tarde.</p>
            @else
                <h4>{{ $user->signo->simbolo }} {{ $user->signo->nombre }}</h4>
                <p class="texto-lectura">{{ $lecturaHoy['texto'] }}</p>
                <a href="{{ route('horoscopo.show', $user->signo) }}" class="btn btn-morado btn-sm">Ver lectura completa</a>
                <a href="{{ route('horoscopo.pdf', $user->signo) }}" class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf"></i> Descargar PDF</a>
            @endif
        </div>
    </div>

    <!-- Números -->
    <div class="row mb-4 text-center">
        <div class="col-md-4 mb-2">
            <div class="card p-3">
                <h3>{{ $totales['lecturas'] }}</h3>
                <span>Lecturas guardadas</span>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card p-3">
                <h3>{{ $totales['favoritas'] }}</h3>
                <span>Lecturas favoritas</span>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card p-3">
                <h3>{{ $totales['usuarios'] }}</h3>
                <span>Usuarios registrados</span>
            </div>
        </div>
    </div>

    <!-- Gráficas -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">Usuarios registrados por signo</div>
                <div class="card-body">
                    <canvas id="graficaUsuarios"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">Mis lecturas guardadas por signo</div>
                <div class="card-body">
                    <canvas id="graficaLecturas" style="max-height: 280px;"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.js"></script>
    <script>
        const etiquetas = @json($grafica['etiquetas']);

        new Chart(document.getElementById('graficaUsuarios'), {
            type: 'bar',
            data: {
                labels: etiquetas,
                datasets: [{
                    label: 'Usuarios',
                    data: @json($grafica['usuarios']),
                    backgroundColor: '#6f42c1'
                }]
            },
            options: { scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
        });

        new Chart(document.getElementById('graficaLecturas'), {
            type: 'doughnut',
            data: {
                labels: etiquetas,
                datasets: [{
                    data: @json($grafica['lecturas']),
                    backgroundColor: ['#e74c3c', '#27ae60', '#f1c40f', '#3498db', '#e67e22', '#16a085',
                                      '#9b59b6', '#c0392b', '#d35400', '#7f8c8d', '#2980b9', '#8e44ad']
                }]
            },
            options: { plugins: { legend: { position: 'right' } } }
        });
    </script>
@endpush
