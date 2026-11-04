@extends('layouts.panel')

@section('titulo', 'Nuevo signo')

@section('contenido')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('signos.store') }}" method="POST" enctype="multipart/form-data">
                @include('signos._formulario')
            </form>
        </div>
    </div>
@endsection
