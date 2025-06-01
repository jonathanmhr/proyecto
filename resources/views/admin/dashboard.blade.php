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
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

                <a href="{{ route('admin.charts.index') }}"
                    class="bg-gradient-to-r from-indigo-600 to-indigo-400 hover:from-indigo-500 hover:to-indigo-300 text-white font-bold py-4 px-6 rounded-xl flex justify-center items-center gap-4 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <span class="text-3xl">🧾</span> Generar reporte
                </a>

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
    @endpush

</x-app-layout>
