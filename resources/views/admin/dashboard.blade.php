<x-app-layout>
    <div class="container mx-auto px-4 py-6 space-y-10">

        {{-- Mensajes flash --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- 1. Resumen de Actividad --}}
        <section>
            <h1 class="text-3xl font-bold mb-6">Panel General - Admin Total</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                {{-- Tarjeta: Usuarios totales --}}
                <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-4xl font-bold text-indigo-600">{{ $totalUsuarios ?? 0 }}</p>
                        <p class="text-gray-600 mt-1 flex items-center gap-1">👥 Usuarios totales</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}"
                        class="mt-4 inline-block text-indigo-500 hover:underline text-sm font-semibold">Ver más</a>
                </div>

                {{-- Tarjeta: Usuarios activos hoy --}}
                <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-4xl font-bold text-blue-600">{{ $usuariosActivosHoy ?? 0 }}</p>
                        <p class="text-gray-600 mt-1 flex items-center gap-1">📈 Usuarios activos hoy</p>
                    </div>
                    <a href="{{ route('admin.usuarios.conectados') }}"
                        class="mt-4 inline-block text-blue-500 hover:underline text-sm font-semibold">Ver actividad</a>
                </div>

                {{-- Tarjeta: Inactivos +7 días --}}
                <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-4xl font-bold text-red-600">{{ $inactivosMas7Dias ?? 0 }}</p>
                        <p class="text-gray-600 mt-1 flex items-center gap-1">⏱️ Inactivos +7 días</p>
                    </div>
                    <a href="{{ route('admin.usuarios.inactivos') }}"
                        class="mt-4 inline-block text-red-500 hover:underline text-sm font-semibold">Revisar</a>
                </div>

                {{-- Tarjeta: Entrenadores activos --}}
                <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-4xl font-bold text-green-600">{{ $entrenadoresActivos ?? 0 }}</p>
                        <p class="text-gray-600 mt-1 flex items-center gap-1">🏋️ Entrenadores activos</p>
                    </div>
                    <a href="{{ route('admin.entrenadores') }}"
                        class="mt-4 inline-block text-green-500 hover:underline text-sm font-semibold">Ver
                        entrenadores</a>
                </div>

                {{-- Tarjeta: Grupos creados --}}
                <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-4xl font-bold text-yellow-600">{{ $gruposCreados ?? 0 }}</p>
                        <p class="text-gray-600 mt-1 flex items-center gap-1">👥 Grupos creados</p>
                    </div>
                    <a href="{{ route('admin.roles.index') }}"
                        class="mt-4 inline-block text-yellow-500 hover:underline text-sm font-semibold">Ver grupos</a>
                </div>
            </div>
        </section>

        {{-- 2. Acciones rápidas --}}
        <section>
            <h2 class="text-2xl font-semibold mb-4">Acciones rápidas</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

                <a href="{{ route('admin.users.index') }}"
                    class="bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow">
                    <span class="text-2xl">➕</span> Crear nuevo usuario
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow">
                    <span class="text-2xl">🧾</span> Generar reporte
                </a>

                <a href="{{ route('admin.notificaciones.index') }}"
                    class="bg-pink-100 hover:bg-pink-200 text-pink-700 font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow">
                    <span class="text-2xl">📤</span> Enviar anuncio
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow">
                    <span class="text-2xl">👥</span> Gestionar usuarios
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow">
                    <span class="text-2xl">👨‍👩‍👧‍👦</span> Gestionar grupos
                </a>
            </div>
        </section>

        {{-- 3. Notificaciones --}}
        <section>
            <h2 class="text-2xl font-semibold mb-4">Notificaciones</h2>
            <ul class="bg-white shadow rounded-xl p-6 space-y-3 max-h-56 overflow-y-auto">
                @foreach ($alertas ?? [] as $alerta)
                    <li
                        class="flex items-center gap-3 font-semibold
                {{ str_starts_with($alerta->icono, '⚠️') ? 'text-yellow-600' : (str_starts_with($alerta->icono, '✅') ? 'text-green-600' : 'text-red-600') }}">
                        {!! $alerta->icono !!} {{ $alerta->titulo }} - <small>de {{ $alerta->remitente }}</small>
                    </li>
                @endforeach
            </ul>
        </section>


        <section>
            <h2 class="text-2xl font-semibold mb-4">Actividad reciente</h2>
            <div class="bg-white shadow rounded-xl p-6 max-h-80 overflow-y-auto space-y-4">

                <div>
                    <h3 class="font-semibold">Usuarios registrados recientemente</h3>
                    <ul class="list-disc list-inside text-gray-700 mt-2">
                        @foreach ($usuariosRecientes ?? [] as $user)
                            <li>{{ $user->name }} - {{ $user->created_at->format('Y-m-d') }}</li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold">Cambios hechos por otros admins</h3>
                    <ul class="list-disc list-inside text-gray-700 mt-2">
                        {{-- Aquí podrías cargar datos dinámicos desde logs o auditoría --}}
                        <li>Juan Pérez actualizó el perfil de Ana López</li>
                        <li>María Gómez creó un nuevo grupo "Equipo Sur"</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold">Últimos contenidos publicados</h3>
                    <ul class="list-disc list-inside text-gray-700 mt-2">
                        <li>Nuevo entrenamiento HIIT - 2025-05-15</li>
                        <li>Blog: Alimentación saludable - 2025-05-14</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold">Notificaciones enviadas recientemente</h3>
                    <ul class="list-disc list-inside text-gray-700 mt-2">
                        @foreach ($notificacionesEnviadas ?? [] as $notificacion)
                            <li>
                                {{ $notificacion->titulo }} -
                                <span
                                    class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($notificacion->fecha)->format('Y-m-d H:i') }}</span>
                                -
                                <em class="text-gray-600">Enviado por: {{ $notificacion->remitente }}</em>
                            </li>
                        @endforeach
                    </ul>
                </div>


            </div>
        </section>


        {{-- 5. Gráficos --}}
        <section>
            <h2 class="text-2xl font-semibold mb-4">Gráficos</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="font-semibold mb-3">Progreso promedio semanal</h3>
                    <div class="bg-gray-100 rounded p-10 text-center text-gray-500"><livewire:users-per-month-chart/></div>
                </div>

                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="font-semibold mb-3">Actividad por grupo o entrenador</h3>
                    <div class="bg-gray-100 rounded p-10 text-center text-gray-500">[Gráfico de barras aquí]</div>
                </div>

                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="font-semibold mb-3">Distribución de usuarios por rol</h3>
                    <div class="bg-gray-100 rounded p-10 text-center text-gray-500">[Gráfico circular o torta aquí]
                    </div>
                </div>

            </div>
        </section>
    </div>
</x-app-layout>
