<!-- resources/views/admin-entrenador/clases/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Clases del Admin Entrenador</h1>
        <a href="{{ route('admin-entrenador.clases.create') }}" class="btn btn-primary">Crear Nueva Clase</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clases as $clase)
                    <tr>
                        <td>{{ $clase->nombre }}</td>
                        <td>
                            <a href="{{ route('admin-entrenador.clases.edit', $clase->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('admin-entrenador.clases.destroy', $clase->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
