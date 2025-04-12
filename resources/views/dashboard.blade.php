<!-- resources/views/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <h3 class="text-2xl font-bold">Bienvenido, {{ auth()->user()->name }}!</h3>
            <p>Correo electrónico: {{ auth()->user()->email }}</p>

            {{-- Información del perfil --}}
            @if($perfil)
                <div class="mb-6">
                    <h4 class="text-xl font-semibold">Perfil</h4>
                    <p>Fecha de nacimiento: {{ $perfil->fecha_nacimiento }}</p>
                    <p>Peso: {{ $perfil->peso }} kg</p>
                    <p>Altura: {{ $perfil->altura }} cm</p>
                    <p>Objetivo: {{ $perfil->objetivo }}</p>
                </div>
            @else
                <div class="mb-6">
                    <p>¡No tienes un perfil completo! <a href="{{ route('perfil.create') }}" class="text-blue-500">Haz clic aquí para completarlo.</a></p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>