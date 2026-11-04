@extends('layouts.panel')

@section('titulo', 'Nueva lectura')

@section('contenido')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('lecturas.store') }}" method="POST">
                @include('lecturas._formulario')
            </form>
        </div>
    </div>
@endsection
