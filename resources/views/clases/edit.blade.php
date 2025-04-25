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
            </div>
        </div>
    </div>
</x-app-layout>
