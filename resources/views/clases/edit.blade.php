<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Clase: ') . $clase->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form method="POST" action="{{ route('entrenador.clases.update', $clase) }}">
                    @csrf
                    @method('PUT')

                    @can('admin_entrenador')
                        <!-- Si es admin-entrenador, permite editar nombre y descripción -->
                        <div class="form-group">
                            <label for="nombre">Nombre de la Clase</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $clase->nombre) }}" class="form-control @error('nombre') is-invalid @enderror" required>
                            @error('nombre')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" required>{{ old('descripcion', $clase->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    @endcan

                    <!-- Campos editables para el entrenador -->
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha de Inicio</label>
                        <input type="datetime-local" name="fecha_inicio" value="{{ old('fecha_inicio', $clase->fecha_inicio->format('Y-m-d\TH:i')) }}" class="form-control @error('fecha_inicio') is-invalid @enderror" required>
                        @error('fecha_inicio')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_fin">Fecha de Fin</label>
                        <input type="datetime-local" name="fecha_fin" value="{{ old('fecha_fin', $clase->fecha_fin->format('Y-m-d\TH:i')) }}" class="form-control @error('fecha_fin') is-invalid @enderror" required>
                        @error('fecha_fin')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="cupos_maximos">Cupos Máximos</label>
                        <input type="number" name="cupos_maximos" value="{{ old('cupos_maximos', $clase->cupos_maximos) }}" class="form-control @error('cupos_maximos') is-invalid @enderror" required>
                        @error('cupos_maximos')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar Clase</button>
                </form>

                <h3>Usuarios Inscritos</h3>
                <ul>
                    @foreach ($usuarios as $user)
                        <li>
                            {{ $user->name }}
                            <form method="POST" action="{{ route('entrenador.clases.eliminarUsuario', [$clase, $user]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </li>
                    @endforeach
                </ul>

                @can('admin_entrenador')
                    <h3>Agregar Usuario</h3>
                    <form method="POST" action="{{ route('entrenador.clases.agregarUsuario', $clase) }}">
                        @csrf
                        <select name="id_usuario" class="form-control">
                            @foreach ($todosLosUsuarios as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->name }} ({{ $usuario->email }})</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-success mt-2">Agregar Usuario</button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
