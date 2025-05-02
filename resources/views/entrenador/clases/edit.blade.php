<!-- resources/views/entrenador/clases/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Clase: ') }} {{ $clase->nombre }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Alumnos Suscritos a la Clase</h1>

        <!-- Lista de alumnos suscritos -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl shadow">
            <h3 class="text-xl font-semibold text-blue-800 mb-4">Alumnos Suscritos</h3>

            @forelse ($clase->usuarios as $usuario)
                <div class="border-b border-blue-200 pb-2 mb-2">
                    <div class="text-blue-900 font-medium">{{ $usuario->name }}</div>
                    <div class="text-sm text-blue-700">{{ $usuario->email }}</div>
                    <div class="text-sm text-blue-700">
                        Estado de la Suscripción:
                        @if ($usuario->pivot->estado === 'pendiente')
                            <span class="text-yellow-500">Pendiente</span>
                        @elseif ($usuario->pivot->estado === 'aceptado')
                            <span class="text-green-500">Aceptado</span>
                        @else
                            <span class="text-red-500">Rechazado</span>
                        @endif
                    </div>

                    <!-- Formulario para aceptar -->
                    <form
                        action="{{ route('entrenador.suscripcion.aceptar', ['clase' => $clase->id_clase, 'usuario' => $usuario->id]) }}"
                        method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Aceptar</button>
                    </form>

                    <!-- Formulario para rechazar -->
                    <form
                        action="{{ route('entrenador.suscripcion.rechazar', ['clase' => $clase->id_clase, 'usuario' => $usuario->id]) }}"
                        method="POST" class="inline-block ml-4">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Rechazar</button>
                    </form>
                </div>
            @empty
                <p class="text-blue-600">No hay alumnos suscritos a esta clase.</p>
            @endforelse
        </div>

        <!-- Botón para regresar -->
        <div class="mt-6">
            <a href="{{ route('entrenador.clase.index') }}" class="text-blue-500 hover:underline">Volver a la lista de clases</a>
        </div>
    </div>
</x-app-layout>
