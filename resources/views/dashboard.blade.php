<!-- resources/views/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($perfil)
                <!-- Si el perfil existe, mostrar los datos y opción de editar -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-xl font-semibold">Tu Perfil</h3>
                    <p><strong>Fecha de nacimiento:</strong> {{ $perfil->fecha_nacimiento }}</p>
                    <p><strong>Peso:</strong> {{ $perfil->peso }} kg</p>
                    <p><strong>Altura:</strong> {{ $perfil->altura }} cm</p>
                    <p><strong>Objetivo:</strong> {{ $perfil->objetivo }}</p>
                    <p><strong>Nivel de entrenamiento:</strong> 
                        @if ($perfil->id_nivel == 1) Principiante
                        @elseif ($perfil->id_nivel == 2) Intermedio
                        @else Avanzado
                        @endif
                    </p>
                    <a href="{{ route('perfil.update') }}" class="text-blue-500 mt-4 block">Editar perfil</a>
                </div>
            @else
                <!-- Si el perfil no existe, mostrar mensaje y enlace para crearlo -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-yellow-800 font-semibold">
                        ¡No tienes un perfil completo!
                        <a href="{{ route('perfil.create') }}" class="text-blue-500 font-bold hover:underline">Haz clic aquí para completarlo.</a>
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
