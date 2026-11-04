@extends('layouts.panel')

@section('titulo', 'Editar lectura')

@section('contenido')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('lecturas.update', $lectura) }}" method="POST">
                @method('PUT')
                @include('lecturas._formulario')
            </form>
        </div>
    </div>
@endsection
