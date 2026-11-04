@extends('layouts.panel')

@section('titulo', 'Listado de signos')

@section('contenido')
    <a href="{{ route('signos.create') }}" class="btn btn-morado mb-3"><i class="bi bi-plus-circle"></i> Nuevo signo</a>

    <div class="card">
        <div class="card-body">
            <table id="tablaSignos" class="table table-striped table-bordered align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Fechas</th>
                        <th>Elemento</th>
                        <th>Usuarios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($signos as $signo)
                        <tr>
                            <td>{{ $signo->id }}</td>
                            <td>
                                @if ($signo->imagen)
                                    <img src="{{ $signo->imagenUrl() }}" alt="{{ $signo->nombre }}" class="imagen-signo">
                                @else
                                    <span class="fs-3">{{ $signo->simbolo }}</span>
                                @endif
                            </td>
                            <td>{{ $signo->nombre }} <small class="text-muted">({{ $signo->slug }})</small></td>
                            <td>{{ $signo->fecha_inicio }} - {{ $signo->fecha_fin }}</td>
                            <td>{{ $signo->elemento }}</td>
                            <td>{{ $signo->users_count }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('signos.show', $signo) }}" class="btn btn-info btn-sm" title="Ver"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('signos.edit', $signo) }}" class="btn btn-warning btn-sm" title="Editar"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('signos.destroy', $signo) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Seguro que quieres eliminar este signo? También se borrarán sus lecturas guardadas.')">
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

@include('partials.datatables', ['tabla' => '#tablaSignos'])
