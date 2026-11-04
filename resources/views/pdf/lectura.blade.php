<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Horóscopo de {{ $signo->nombre }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; }
        .encabezado { background-color: #5b2c83; color: white; padding: 15px; text-align: center; }
        .encabezado h1 { margin: 0; }
        .datos { margin: 20px 0; }
        .datos td { padding: 4px 10px 4px 0; }
        .lectura { border-left: 4px solid #6f42c1; background-color: #f5f0fb; padding: 15px; font-size: 14px; line-height: 1.6; }
        .pie { margin-top: 40px; font-size: 11px; color: #888; text-align: center; }
    </style>
</head>
<body>
    <div class="encabezado">
        <h1>Horóscopo Web</h1>
        <div>Lectura del día</div>
    </div>

    <table class="datos">
        <tr><td><strong>Signo:</strong></td><td>{{ $signo->nombre }} ({{ $signo->fecha_inicio }} - {{ $signo->fecha_fin }})</td></tr>
        <tr><td><strong>Elemento:</strong></td><td>{{ $signo->elemento }}</td></tr>
        <tr><td><strong>Fecha:</strong></td><td>{{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</td></tr>
        <tr><td><strong>Descargado por:</strong></td><td>{{ $user->name }}</td></tr>
    </table>

    <h3>Tu lectura</h3>
    <div class="lectura">{{ $texto }}</div>

    @if ($nota)
        <h3>Mi nota</h3>
        <p>{{ $nota }}</p>
    @endif

    <div class="pie">
        Generado el {{ now()->format('d/m/Y H:i') }} · Fuente: api-ninjas.com
    </div>
</body>
</html>
