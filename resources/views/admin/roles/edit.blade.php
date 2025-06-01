<x-app-layout>
    <x-slot name="header">
        {{-- Título del slot header - Cambiado a texto blanco --}}
        <h2 class="font-semibold text-xl text-white leading-tight">Editar rol {{ $role->name }}</h2>
    </x-slot>

    <div class="py-6 max-w-lg mx-auto sm:px-6 lg:px-8">
        {{-- Formulario - Fondo oscuro, padding, esquinas redondeadas, sombra y borde --}}
        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="bg-gray-800 p-6 rounded-lg shadow-lg border border-gray-700">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                {{-- Etiquetas de texto claro --}}
                <label for="name" class="block font-medium text-gray-300">Nombre (clave)</label>
                {{-- Input oscuro con borde y foco acorde --}}
                <input type="text" name="name" id="name" required
                       class="mt-1 block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       value="{{ old('name', $role->name) }}">
                {{-- Mensaje de error - Rojo más claro --}}
                @error('name') <p class="text-red-400 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                {{-- Etiquetas de texto claro --}}
                <label for="title" class="block font-medium text-gray-300">Título (opcional)</label>
                {{-- Input oscuro con borde y foco acorde --}}
                <input type="text" name="title" id="title"
                       class="mt-1 block w-full rounded border-gray-600 bg-gray-700 text-white shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       value="{{ old('title', $role->title) }}">
                {{-- Mensaje de error - Rojo más claro --}}
                @error('title') <p class="text-red-400 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-between items-center mt-6"> {{-- Margen superior para separación --}}
                {{-- Enlace Cancelar - Gris oscuro y hover sutil --}}
                <a href="{{ route('admin.roles.index') }}" class="text-gray-400 hover:text-gray-300 hover:underline transition-colors">Cancelar</a>
                {{-- Botón Actualizar - Verde para acción positiva --}}
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 shadow transition-colors">Actualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>