@extends('layouts.panel')

@section('titulo', 'Mis lecturas')

@section('contenido')
    <p class="text-muted">Aquí están las lecturas que guardaste. También puedes agregar una a mano.</p>
    <a href="{{ route('lecturas.create') }}" class="btn btn-morado mb-3"><i class="bi bi-plus-circle"></i> Nueva lectura</a>

    <div class="card">
        <div class="card-body">
            <table id="tablaLecturas" class="table table-striped table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Signo</th>
                        <th>Lectura</th>
                        <th>Nota</th>
                        <th>Favorita</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lecturas as $lectura)
                        <tr>
                            <td>{{ $lectura->id }}</td>
                            <td data-order="{{ $lectura->fecha->format('Y-m-d') }}">{{ $lectura->fecha->format('d/m/Y') }}</td>
                            <td>{{ $lectura->signo->simbolo }} {{ $lectura->signo->nombre }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($lectura->texto, 70) }}</td>
                            <td>{{ $lectura->nota }}</td>
                            <td class="text-center">{!! $lectura->favorita ? '⭐' : '' !!}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('lecturas.show', $lectura) }}" class="btn btn-info btn-sm" title="Ver"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('lecturas.edit', $lectura) }}" class="btn btn-warning btn-sm" title="Editar"><i class="bi bi-pencil"></i></a>
                                <a href="{{ route('lecturas.pdf', $lectura) }}" class="btn btn-secondary btn-sm" title="PDF"><i class="bi bi-file-earmark-pdf"></i></a>
                                <form action="{{ route('lecturas.destroy', $lectura) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar esta lectura?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@include('partials.datatables', ['tabla' => '#tablaLecturas'])
