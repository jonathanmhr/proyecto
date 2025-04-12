<!-- resources/views/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($perfil) <!-- Verifica si el perfil existe -->
                    <p>Fecha de nacimiento: {{ $perfil->fecha_nacimiento }}</p>
                    <p>Peso: {{ $perfil->peso }} kg</p>
                    <p>Altura: {{ $perfil->altura }} cm</p>
                    <p>Objetivo: {{ $perfil->objetivo }}</p>
                @else
                    <div class="flex justify-center items-center p-6 bg-yellow-100 border border-yellow-400 rounded-md shadow-lg mb-6">
                        <p class="text-yellow-800 font-semibold">
                            ¡No tienes un perfil completo! 
                            <a href="{{ route('perfil.edit') }}" class="text-blue-500 font-bold hover:underline">Haz clic aquí para completarlo.</a>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
