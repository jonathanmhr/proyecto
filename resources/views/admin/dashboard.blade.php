<x-app-layout>
    <div class="container mx-auto px-4 py-6 space-y-10 bg-gray-800 text-gray-200 min-h-screen rounded-xl shadow-lg mt-4">

        {{-- Mensajes flash --}}
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

        {{-- 1. Resumen de Actividad --}}
        <section>
            <h1 class="text-3xl font-bold mb-6 text-white">Panel General - Admin Total</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                {{-- Tarjeta: Usuarios totales --}}
                <div class="bg-gray-700 rounded-xl shadow-md p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-4xl font-bold text-indigo-400">{{ $totalUsuarios ?? 0 }}</p>
                        <p class="text-gray-300 mt-1 flex items-center gap-1">👥 Usuarios totales</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}"
                        class="mt-4 inline-block text-indigo-300 hover:underline text-sm font-semibold">Ver más</a>
                </div>

                {{-- Tarjeta: Usuarios activos hoy --}}
                <div class="bg-gray-700 rounded-xl shadow-md p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-4xl font-bold text-blue-400">{{ $usuariosActivosHoy ?? 0 }}</p>
                        <p class="text-gray-300 mt-1 flex items-center gap-1">📈 Usuarios activos hoy</p>
                    </div>
                    <a href="{{ route('admin.usuarios.conectados') }}"
                        class="mt-4 inline-block text-blue-300 hover:underline text-sm font-semibold">Ver actividad</a>
                </div>

                {{-- Tarjeta: Inactivos +7 días --}}
                <div class="bg-gray-700 rounded-xl shadow-md p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-4xl font-bold text-red-400">{{ $inactivosMas7Dias ?? 0 }}</p>
                        <p class="text-gray-300 mt-1 flex items-center gap-1">⏱️ Inactivos +7 días</p>
                    </div>
                    <a href="{{ route('admin.usuarios.inactivos') }}"
                        class="mt-4 inline-block text-red-300 hover:underline text-sm font-semibold">Revisar</a>
                </div>

                {{-- Tarjeta: Entrenadores activos --}}
                <div class="bg-gray-700 rounded-xl shadow-md p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-4xl font-bold text-green-400">{{ $entrenadoresActivos ?? 0 }}</p>
                        <p class="text-gray-300 mt-1 flex items-center gap-1">🏋️ Entrenadores activos</p>
                    </div>
                    <a href="{{ route('admin.entrenadores') }}"
                        class="mt-4 inline-block text-green-300 hover:underline text-sm font-semibold">Ver
                        entrenadores</a>
                </div>

                {{-- Tarjeta: Grupos creados --}}
                <div class="bg-gray-700 rounded-xl shadow-md p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-4xl font-bold text-yellow-400">{{ $gruposCreados ?? 0 }}</p>
                        <p class="text-gray-300 mt-1 flex items-center gap-1">👥 Grupos creados</p>
                    </div>
                    <a href="{{ route('admin.roles.index') }}"
                        class="mt-4 inline-block text-yellow-300 hover:underline text-sm font-semibold">Ver grupos</a>
                </div>
            </div>
        </section>
        {{-- 2. Acciones rápidas --}}
        <section>
            <h2 class="text-2xl font-semibold mb-4 text-white">Acciones rápidas</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">

                <a href="{{ route('admin.notificaciones.create') }}"
                    class="bg-gradient-to-r from-pink-600 to-pink-400 hover:from-pink-500 hover:to-pink-300 text-white font-bold py-4 px-6 rounded-xl flex justify-center items-center gap-4 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <span class="text-3xl">📤</span> Enviar anuncio
                </a>

                {{-- Nuevo acceso rápido para pedidos de usuarios --}}
                <a href="{{ route('admin.compras.index') }}"
                    class="bg-gradient-to-r from-purple-600 to-purple-400 hover:from-purple-500 hover:to-purple-300 text-white font-bold py-4 px-6 rounded-xl flex justify-center items-center gap-4 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <span class="text-3xl">📦</span> Pedidos de usuarios
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="bg-gradient-to-r from-blue-600 to-blue-400 hover:from-blue-500 hover:to-blue-300 text-white font-bold py-4 px-6 rounded-xl flex justify-center items-center gap-4 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <span class="text-3xl">👥</span> Gestionar usuarios
                </a>

                <a href="{{ route('admin.roles.index') }}"
                    class="bg-gradient-to-r from-yellow-600 to-yellow-400 hover:from-yellow-500 hover:to-yellow-300 text-white font-bold py-4 px-6 rounded-xl flex justify-center items-center gap-4 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <span class="text-3xl">👨‍👩‍👧‍👦</span> Gestionar grupos
                </a>

                <a href="{{ route('admin.almacen.index') }}"
                    class="bg-gradient-to-r from-cyan-600 to-cyan-400 hover:from-cyan-500 hover:to-cyan-300 text-white font-bold py-4 px-6 rounded-xl flex justify-center items-center gap-4 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <span class="text-3xl">📦</span> Gestionar Productos
                </a>
            </div>
        </section>

        {{-- 3. Notificaciones --}}
        <section>
            <h2 class="text-2xl font-semibold mb-4 text-white">Notificaciones</h2>
            <ul class="bg-gray-700 shadow-md rounded-xl p-6 space-y-3 max-h-56 overflow-y-auto">
                @foreach ($alertas ?? [] as $alerta)
                    <li
                        class="flex items-center gap-3 font-semibold {{ str_starts_with($alerta->icono, '⚠️') ? 'text-yellow-400' : (str_starts_with($alerta->icono, '✅') ? 'text-green-400' : 'text-red-400') }}">
                        {!! $alerta->icono !!} <span class="text-gray-300">{{ $alerta->titulo }}</span> - <small
                            class="text-gray-400">de {{ $alerta->remitente }}</small>
                    </li>
                @endforeach
            </ul>
        </section>

        {{-- Sección de Configuración de Vista de Inicio --}}
        <section>
            <h2 class="text-2xl font-semibold mb-4 text-white">Configuración de Vista de Inicio</h2>
            <div class="bg-gray-700 shadow-md rounded-xl p-6">
                <div>
                    <label for="welcomeViewSelect" class="block text-sm font-medium text-gray-300 mb-1">Seleccionar vista para la página de inicio :</label>
                    <select id="welcomeViewSelect" name="welcome_view_selector" class="block w-full sm:w-1/2 md:w-1/3 bg-gray-600 border border-gray-500 text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
                        <option value="welcome" {{ ($currentWelcomeViewDb ?? 'welcome') == 'welcome' ? 'selected' : '' }}>Bienvenida 1</option>
                        <option value="welcome2" {{ ($currentWelcomeViewDb ?? 'welcome') == 'welcome2' ? 'selected' : '' }}>Bienvenida 2</option>
                        <option value="welcome3" {{ ($currentWelcomeViewDb ?? 'welcome') == 'welcome3' ? 'selected' : '' }}>Bienvenida 3</option>
                    </select>
                    <small id="updateWelcomeViewStatus" class="mt-2 text-sm text-gray-400"></small>
                </div>
            </div>
        </section>

        {{-- Actividad reciente --}}
        <section>
            <h2 class="text-2xl font-semibold mb-4 text-white">Actividad reciente</h2>
            <div class="bg-gray-700 shadow-md rounded-xl p-6 max-h-80 overflow-y-auto space-y-4">

                <div>
                    <h3 class="font-semibold text-white">Usuarios registrados recientemente</h3>
                    <ul class="list-disc list-inside text-gray-300 mt-2">
                        @foreach ($usuariosRecientes ?? [] as $user)
                            <li>{{ $user->name }} - <span
                                    class="text-gray-400">{{ $user->created_at->format('Y-m-d') }}</span></li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-white">Cambios hechos por otros admins</h3>
                    <ul class="list-disc list-inside text-gray-300 mt-2">
                        {{-- Aquí podrías cargar datos dinámicos desde logs o auditoría --}}
                        <li>Juan Pérez actualizó el perfil de Ana López</li>
                        <li>María Gómez creó un nuevo grupo "Equipo Sur"</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-white">Últimos contenidos publicados</h3>
                    <ul class="list-disc list-inside text-gray-300 mt-2">
                        <li>Nuevo entrenamiento HIIT - <span class="text-gray-400">2025-05-15</span></li>
                        <li>Blog: Alimentación saludable - <span class="text-gray-400">2025-05-14</span></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-white">Notificaciones enviadas recientemente</h3>
                    <ul class="list-disc list-inside text-gray-300 mt-2">
                        @foreach ($notificacionesEnviadas ?? [] as $notificacion)
                            <li>
                                <span class="text-gray-300">{{ $notificacion->titulo }}</span> -
                                <span
                                    class="text-gray-400 text-sm">{{ \Carbon\Carbon::parse($notificacion->fecha)->format('Y-m-d H:i') }}</span>
                                -
                                <em class="text-gray-400">Enviado por: {{ $notificacion->remitente }}</em>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </section>

        {{-- 5. Gráficos (Aquí es donde integraremos tus nuevos gráficos) --}}
        <section>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-white">Gráficos de Actividad Mensual</h2>
                <button id="refreshCharts"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition duration-200">
                    <i data-feather="refresh-ccw" class="w-5 h-5"></i>
                    <span>Actualizar Gráficos</span>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Gráfico de Altas de Usuarios --}}
                <div class="bg-gray-700 shadow-md rounded-xl p-6">
                    <h3 class="font-semibold mb-3 text-white">Altas de Usuarios por Mes</h3>
                    <div id="usersChart"></div>
                </div>

                {{-- Gráfico de Altas y Bajas de Suscripciones --}}
                <div class="bg-gray-700 shadow-md rounded-xl p-6">
                    <h3 class="font-semibold mb-3 text-white">Altas y Bajas de Suscripciones</h3>
                    <div id="subscriptionsChart"></div>
                </div>

                {{-- Gráfico de Creación de Clases --}}
                <div class="bg-gray-700 shadow-md rounded-xl p-6">
                    <h3 class="font-semibold mb-3 text-white">Creación de Clases por Mes</h3>
                    <div id="classesChart"></div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        @vite('resources/js/scripts/dashboardCharts.js')

        {{-- Script para el selector de vista de bienvenida --}}
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectElement = document.getElementById('welcomeViewSelect');
            const statusElement = document.getElementById('updateWelcomeViewStatus');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (selectElement && csrfToken) {
                selectElement.addEventListener('change', function () {
                    const selectedView = this.value;
                    if (statusElement) {
                        statusElement.textContent = 'Actualizando...';
                        statusElement.className = 'mt-2 text-sm text-blue-400'; 
                    }

                    fetch("{{ route('admin.settings.updateWelcomeView') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ view_name: selectedView })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => { throw err; });
                        }
                        return response.json(); 
                    })
                    .then(data => {
                        if (statusElement) {
                            if (data.success) {
                                statusElement.textContent = data.message;
                                statusElement.className = 'mt-2 text-sm text-green-400'; 
                            } else {
                                statusElement.textContent = 'Error: ' + (data.message || 'No se pudo actualizar.');
                                statusElement.className = 'mt-2 text-sm text-red-400'; 
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error al actualizar vista de bienvenida:', error);
                        if (statusElement) {
                            let errorMessage = 'Error de conexión o respuesta inesperada del servidor.';
                            if (error && error.message) {
                                 errorMessage = 'Error: ' + error.message;
                            } else if (typeof error === 'string') { 
                                errorMessage = 'Error: ' + error;
                            }
                            statusElement.textContent = errorMessage;
                            statusElement.className = 'mt-2 text-sm text-red-400'; 
                        }
                    });
                });
            } else {
                if (!selectElement) console.error('Elemento select #welcomeViewSelect no encontrado.');
                if (!csrfToken) console.error('Meta tag CSRF no encontrado. Asegúrate de que tu layout principal (<head>) lo incluya: <meta name="csrf-token" content="{{ csrf_token() }}">');
            }
        });
        </script>
    @endpush

</x-app-layout>