<!-- resources/views/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Información del usuario -->
                <div class="mb-6">
                    <h3 class="text-2xl font-bold">Bienvenido, {{ auth()->user()->name }}!</h3>
                    <p>Correo electrónico: {{ auth()->user()->email }}</p>
                </div>

                <!-- Widget de estadísticas -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Ejemplo de un widget de estadísticas -->
                    <div class="bg-gray-100 p-4 rounded-lg shadow">
                        <h4 class="text-xl font-semibold">Estadísticas</h4>
                        <p>Total de Usuarios: 120</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg shadow">
                        <h4 class="text-xl font-semibold">Actividad Reciente</h4>
                        <p>Última actividad: 5 minutos atrás</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg shadow">
                        <h4 class="text-xl font-semibold">Notificaciones</h4>
                        <p>No hay nuevas notificaciones.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
