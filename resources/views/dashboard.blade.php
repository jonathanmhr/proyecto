<!-- resources/views/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Contenido del dashboard basado en el rol -->
                @if($user->isAdmin())
                    <h3>Bienvenido, Administrador</h3>
                    <p>Aquí puedes gestionar usuarios, clases y configuraciones del sistema.</p>
                    <!-- Agrega más contenido para admin aquí -->

                @elseif($user->isTrainer())
                    <h3>Bienvenido, Entrenador</h3>
                    <p>Aquí puedes gestionar las clases y entrenamientos.</p>
                    <!-- Agrega más contenido para trainer aquí -->

                @elseif($user->isClient())
                    <h3>Bienvenido, Cliente</h3>
                    <p>Aquí puedes ver tu progreso y tus entrenamientos.</p>
                    <!-- Agrega más contenido para client aquí -->

                @else
                    <h3>Bienvenido a PowerCore</h3>
                    <p>No tienes un rol asignado aún.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
