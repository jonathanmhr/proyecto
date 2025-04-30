<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">Panel General - Admin Entrenador</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Total de clases -->
            <div class="bg-white shadow rounded-xl p-4">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Clases</h2>
                <p class="text-3xl font-bold text-blue-500">{{ $totalClases }}</p>
            </div>

            <!-- Total de entrenadores -->
            <div class="bg-white shadow rounded-xl p-4">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Entrenadores</h2>
                <p class="text-3xl font-bold text-green-500">{{ $totalEntrenadores }}</p>
            </div>

            <!-- Total de alumnos -->
            <div class="bg-white shadow rounded-xl p-4">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Alumnos</h2>
                <p class="text-3xl font-bold text-purple-500">{{ $totalAlumnos }}</p>
            </div>
        </div>

        <!-- Sección rápida de accesos -->
        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4">Accesos rápidos</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('admin.users.index') }}"
                   class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-3 px-4 rounded-xl flex items-center gap-2 transition">
                    <i data-feather="clipboard-list" class="w-5 h-5"></i> Gestionar Clases
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="bg-green-100 hover:bg-green-200 text-green-700 font-semibold py-3 px-4 rounded-xl flex items-center gap-2 transition">
                    <i data-feather="users" class="w-5 h-5"></i> Gestionar Usuarios
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-semibold py-3 px-4 rounded-xl flex items-center gap-2 transition">
                    <i data-feather="user-check" class="w-5 h-5"></i> Ver Entrenadores
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="bg-purple-100 hover:bg-purple-200 text-purple-700 font-semibold py-3 px-4 rounded-xl flex items-center gap-2 transition">
                    <i data-feather="user-plus" class="w-5 h-5"></i> Ver Alumnos
                </a>
            </div>
        </div>

        <!-- Gráficos de desempeño (si es necesario) -->
        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4">Desempeño General</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Progreso de Clases</h3>
                    <div class="bg-gray-100 p-4 rounded-xl">
                        <!-- Aquí iría un gráfico de progreso de clases (puedes usar chart.js o alguna librería) -->
                        <p class="text-center text-gray-500">Gráfico de Clases Aquí</p>
                    </div>
                </div>

                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Progreso de Usuarios</h3>
                    <div class="bg-gray-100 p-4 rounded-xl">
                        <!-- Aquí iría un gráfico de progreso de usuarios -->
                        <p class="text-center text-gray-500">Gráfico de Usuarios Aquí</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
