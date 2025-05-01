<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nueva Clase') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('admin-entrenador.clases.store') }}" method="POST">
                    @csrf

                    <label for="nombre">Nombre de la clase</label>
                    <input type="text" name="nombre" required>

                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion"></textarea>

                    <label for="cupos_maximos">Cupos máximos</label>
                    <input type="number" name="cupos_maximos" required>

                    <label for="fecha_inicio">Fecha de inicio</label>
                    <input type="date" name="fecha_inicio" required>

                    <label for="fecha_fin">Fecha de fin</label>
                    <input type="date" name="fecha_fin" required>

                    <label for="entrenador_id">Entrenador</label>
                    <select name="entrenador_id" required>
                        @foreach ($entrenadores as $entrenador)
                            <option value="{{ $entrenador->id }}">{{ $entrenador->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit">Crear clase</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
