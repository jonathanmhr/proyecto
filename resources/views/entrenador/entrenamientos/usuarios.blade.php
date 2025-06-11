<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Asignar Usuarios al Entrenamiento: {{ $entrenamiento->titulo }}</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <form action="{{ route('entrenador.entrenamientos.asignarUsuarios', $entrenamiento->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold mb-2" for="usuarios">Selecciona usuarios</label>
                <select id="usuarios" name="usuarios[]" multiple class="block w-full rounded-md border-gray-300" size="10" required>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ $entrenamiento->usuarios->contains($usuario->id) ? 'selected' : '' }}>
                            {{ $usuario->name }} ({{ $usuario->email }})
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('usuarios')" class="mt-2" />
            </div>

            <button type="submit" class="mt-6 px-6 py-3 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition">
                Asignar Usuarios
            </button>
        </form>
    </div>
</x-app-layout>
