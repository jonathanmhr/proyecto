<!-- resources/views/admin-entrenador/clases/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Clase: {{ $clase->nombre }}</h1>
        <form action="{{ route('admin-entrenador.clases.update', $clase->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nombre">Nombre de la Clase</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $clase->nombre }}" required>
            </div>
            <button type="submit" class="btn btn-success mt-3">Actualizar Clase</button>
        </form>
    </div>
@endsection
