<!-- resources/views/admin-entrenador/clases/create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crear Nueva Clase</h1>
        <form action="{{ route('admin-entrenador.clases.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre de la Clase</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success mt-3">Crear Clase</button>
        </form>
    </div>
@endsection
