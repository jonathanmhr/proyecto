<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Usuarios que guardaron: {{ $entrenamiento->titulo }}</h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('admin-entrenador.entrenamientos.index') }}" class="text-blue-600 underline mb-4 inline-block">← Volver</a>

        @if($entrenamiento->usuariosGuardaron->isEmpty())
            <p>No hay usuarios que hayan guardado este entrenamiento.</p>
        @else
            <ul class="list-disc pl-5">
                @foreach($entrenamiento->usuariosGuardaron as $usuario)
                    <li>{{ $usuario->name }} ({{ $usuario->email }})</li>
                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>
