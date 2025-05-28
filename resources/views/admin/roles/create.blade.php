<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear nuevo rol</h2>
    </x-slot>

    <div class="py-6 max-w-lg mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('admin.roles.store') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf

            <div class="mb-4">
                <label for="name" class="block font-medium text-gray-700">Nombre (clave)</label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full rounded border-gray-300 shadow-sm" value="{{ old('name') }}">
                @error('name') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="title" class="block font-medium text-gray-700">Título (opcional)</label>
                <input type="text" name="title" id="title" class="mt-1 block w-full rounded border-gray-300 shadow-sm" value="{{ old('title') }}">
                @error('title') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('admin.roles.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
            </div>
        </form>
    </div>
</x-app-layout>
