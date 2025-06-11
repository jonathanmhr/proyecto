<x-app-layout>
    {{-- Contenedor principal con fondo oscuro --}}
    <div class="container mx-auto px-4 py-6 space-y-10 bg-gray-900 text-gray-200 min-h-screen rounded-xl shadow-lg mt-4">

        {{-- Mensajes flash con fondos oscuros --}}
        @if (session('success'))
            <div class="bg-green-700 border border-green-600 text-white px-4 py-3 rounded-lg shadow-md">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-700 border border-red-600 text-white px-4 py-3 rounded-lg shadow-md">
                {{ session('error') }}
            </div>
        @endif

        <h1 class="text-3xl font-bold mb-6 text-white">Panel General - Admin Entrenador</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-gray-800 shadow rounded-xl p-5 flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-300 mb-2">Clases</h2>
                    <p class="text-4xl font-bold text-blue-400">{{ $totalClases }}</p>
                </div>
                {{-- Puedes añadir un enlace aquí si aplica --}}
            </div>

            <div class="bg-gray-800 shadow rounded-xl p-5 flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-300 mb-2">Entrenadores</h2>
                    <p class="text-4xl font-bold text-green-400">{{ $totalEntrenadores }}</p>
                </div>
            </div>

            <div class="bg-gray-800 shadow rounded-xl p-5 flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-300 mb-2">Alumnos</h2>
                    <p class="text-4xl font-bold text-purple-400">{{ $totalAlumnos }}</p>
                </div>
            </div>

            <div class="bg-gray-800 shadow rounded-xl p-5 flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-300 mb-2">Entrenamientos</h2>
                    <p class="text-4xl font-bold text-indigo-400">{{ $totalEntrenamientos }}</p>
                </div>
            </div>

            <div class="bg-gray-800 shadow rounded-xl p-5 flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-300 mb-2">Solicitudes Pendientes</h2>
                    <p class="text-4xl font-bold text-yellow-400">{{ $totalSolicitudesClasesPendientes }}</p>
                </div>
            </div>
        </div>

        <div class="mt-10">
            <h2 class="text-2xl font-semibold mb-4 text-white">Accesos rápidos</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('admin-entrenador.clases.index') }}"
                    class="bg-blue-700 hover:bg-blue-600 text-white font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow-md">
                    <span class="text-2xl"><i data-feather="server" class="w-6 h-6"></i></span> Gestionar Clases
                </a>

                <a href="{{ route('admin-entrenador.alumnos.index') }}"
                    class="bg-green-700 hover:bg-green-600 text-white font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow-md">
                    <span class="text-2xl"><i data-feather="users" class="w-6 h-6"></i></span> Gestionar Alumnos
                </a>

                <a href="{{ route('admin-entrenador.entrenadores.index') }}"
                    class="bg-yellow-700 hover:bg-yellow-600 text-white font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow-md">
                    <span class="text-2xl"><i data-feather="user-check" class="w-6 h-6"></i></span> Gestionar
                    Entrenadores
                </a>

                <a href="{{ route('admin-entrenador.entrenamientos.index') }}"
                    class="bg-indigo-700 hover:bg-indigo-600 text-white font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow-md">
                    <span class="text-2xl"><i data-feather="activity" class="w-6 h-6"></i></span> Gestionar
                    Entrenamientos
                </a>

                <a href="{{ route('admin-entrenador.alumnos.index') }}"
                    class="bg-purple-700 hover:bg-purple-600 text-white font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow-md">
                    <span class="text-2xl"><i data-feather="credit-card" class="w-6 h-6"></i></span> Gestionar pagos
                </a>
                <a href="{{ route('admin-entrenador.dietas.index') }}"
                    class="bg-cyan-700 hover:bg-cyan-600 text-white font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow-md">
                    <span class="text-2xl"><i data-feather="credit-card" class="w-6 h-6"></i></span> Gestionar Dietas
                </a>

                <a href="{{ route('admin-entrenador.solicitudes.index') }}"
                    class="bg-pink-700 hover:bg-pink-600 text-white font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow-md">
                    <span class="text-2xl"><i data-feather="alert-circle" class="w-6 h-6"></i></span> Ver Solicitudes
                </a>
            </div>
        </div>

        <div class="mt-10">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-white">Desempeño General</h2>
                <button id="refreshTrainerCharts"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition duration-200">
                    <i data-feather="refresh-ccw" class="w-5 h-5"></i>
                    <span>Actualizar Gráficos</span>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-800 shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-300 mb-4">Progreso de Clases</h3>
                    <div id="trainerClassesChart"></div>
                </div>

                <div class="bg-gray-800 shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-300 mb-4">Progreso de Usuarios</h3>
                    <div id="trainerUsersChart"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite('resources/js/scripts/trainercharts.js')
    @endpush

</x-app-layout>
