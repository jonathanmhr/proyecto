<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard del Entrenador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Grilla de Secciones -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Panel de Clases -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold">Clases Grupales</h3>
                    <p class="text-gray-600">Administra las clases grupales.</p>
                    <a href="{{ route('entrenador.clases.index') }}" class="text-blue-500 hover:underline">Ver clases</a>
                </div>

                <!-- Panel de Usuarios -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold">Usuarios Inscritos</h3>
                    <p class="text-gray-600">Gestiona los usuarios del gimnasio.</p>
                    <a href="{{ route('entrenador.usuarios.index') }}" class="text-blue-500 hover:underline">Ver usuarios</a>
                </div>

                <!-- Panel de Notificaciones -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold">Notificaciones</h3>
                    <p class="text-gray-600">Envía notificaciones a los usuarios.</p>
                    <a href="{{ route('entrenador.notificaciones.index') }}" class="text-blue-500 hover:underline">Ver notificaciones</a>
                </div>

                <!-- Panel de Estadísticas -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold">Estadísticas</h3>
                    <p class="text-gray-600">Revisa las estadísticas de las clases.</p>
                    <a href="{{ route('entrenador.estadisticas.index') }}" class="text-blue-500 hover:underline">Ver estadísticas</a>
                </div>

                <!-- Panel de Suscripciones -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold">Suscripciones</h3>
                    <p class="text-gray-600">Gestiona las suscripciones de los usuarios.</p>
                    <a href="{{ route('entrenador.suscripciones.index') }}" class="text-blue-500 hover:underline">Ver suscripciones</a>
                </div>

                <!-- Panel de Reportes -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold">Reportes</h3>
                    <p class="text-gray-600">Genera reportes sobre las clases y usuarios.</p>
                    <a href="{{ route('entrenador.reportes.index') }}" class="text-blue-500 hover:underline">Ver reportes</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
