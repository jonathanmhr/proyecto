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
                <div class="p-6">
                    <h3 class="text-xl font-semibold">
                        Bienvenido, {{ $user->name }}! 
                    </h3>
                    <p>Tu rol es: {{ $user->roles->pluck('name')->join(', ') }}</p>

                    <div class="mt-6">
                        @if($user->isAdmin())
                            <h4 class="font-medium">Eres Administrador</h4>
                            <p>Aquí puedes gestionar usuarios, clases y configuraciones del sistema.</p>
                            <!-- Agregar más funcionalidades administrativas -->
                        @elseif($user->isTrainer())
                            <h4 class="font-medium">Eres Entrenador</h4>
                            <p>Aquí puedes gestionar las clases y entrenamientos.</p>
                            <!-- Agregar más funcionalidades de entrenamiento -->
                        @elseif($user->isClient())
                            <h4 class="font-medium">Eres Cliente</h4>
                            <p>Aquí puedes ver tu progreso y tus entrenamientos.</p>
                            <!-- Agregar más funcionalidades para clientes -->
                        @else
                            <h4 class="font-medium">Bienvenido</h4>
                            <p>No tienes un rol asignado aún.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
