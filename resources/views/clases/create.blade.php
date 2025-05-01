<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nueva Clase') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('admin-entrenador.clases.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre de la clase</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion">{{ old('descripcion') }}</textarea>
                    </div>
                
                    <div class="form-group">
                        <label for="cupos_maximos">Cupos máximos</label>
                        <input type="number" class="form-control" id="cupos_maximos" name="cupos_maximos" value="{{ old('cupos_maximos') }}" required min="1">
                    </div>
                
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha de inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
                    </div>
                
                    <div class="form-group">
                        <label for="entrenador_id">Entrenador</label>
                        <select class="form-control" id="entrenador_id" name="entrenador_id" required>
                            @foreach ($entrenadores as $entrenador)
                                <option value="{{ $entrenador->id }}" {{ old('entrenador_id') == $entrenador->id ? 'selected' : '' }}>
                                    {{ $entrenador->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                
                    <button type="submit" class="btn btn-primary">Crear clase</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
