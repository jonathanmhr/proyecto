<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($perfil) <!-- Verifica si el perfil existe -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4">Tu Perfil</h3>
                    <p><strong>Fecha de nacimiento:</strong> {{ $perfil->fecha_nacimiento }}</p>
                    <p><strong>Peso:</strong> {{ $perfil->peso }} kg</p>
                    <p><strong>Altura:</strong> {{ $perfil->altura }} cm</p>
                    <p><strong>Objetivo:</strong> {{ $perfil->objetivo }}</p>
                    <p><strong>Nivel de entrenamiento:</strong> 
                        @if($perfil->id_nivel == 1) 
                            Principiante
                        @elseif($perfil->id_nivel == 2) 
                            Intermedio
                        @else 
                            Avanzado
                        @endif
                    </p>
                </div>
            @else
                <div class="flex justify-center items-center p-6 rounded-md shadow-lg mb-6">
                    <p class="text-yellow-800 font-semibold">
                        ¡No tienes un perfil completo!
                        <a href="{{ route('perfil.edit') }}" class="text-blue-500 font-bold hover:underline">Haz clic aquí para completarlo.</a>
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
