@extends('layouts.panel')

@section('titulo', 'Editar signo: '.$signo->nombre)

@section('contenido')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('signos.update', $signo) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('signos._formulario')
            </form>
        </div>
    </div>
@endsection
