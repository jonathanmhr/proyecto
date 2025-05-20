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
                        <p class="text-4xl font-bold text-indigo-600">{{ $totalUsuarios }}</p>
                        <p class="text-gray-600 mt-1 flex items-center gap-1">👥 Usuarios totales</p>
                    </div>
                    <a href="{{ route('admin.usuarios.index') }}" class="mt-4 inline-block text-indigo-500 hover:underline text-sm font-semibold">Ver más</a>
                </div>

                {{-- Tarjeta: Usuarios activos hoy --}}
                <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-4xl font-bold text-blue-600">{{ $usuariosActivosHoy }}</p>
                        <p class="text-gray-600 mt-1 flex items-center gap-1">📈 Usuarios activos hoy</p>
                    </div>
                    <a href="{{ route('admin.usuarios.activos') }}" class="mt-4 inline-block text-blue-500 hover:underline text-sm font-semibold">Ver actividad</a>
                </div>

                {{-- Tarjeta: Inactivos +7 días --}}
                <div class="bg-white rounded-xl shadow p-5 flex flex-col justify-between">
                    <div>
                        <p class="text-4xl font-bold text-red-600">{{ $inactivosMas7Dias }}</p>
                        <p class="text-gray-600 mt-1 flex items-center gap-1">⏱️ Inactivos +7 días</p>
                    </div>
                    <a href="{{ route('admin.usuarios.inactivos') }}" class="mt-4 inline-block text-red-500 hover:underline text-sm font-semibold">Revisar</a>
                </div>
            </div>
        </section>

        {{-- 2. Acciones rápidas --}}
        <section>
            <h2 class="text-2xl font-semibold mb-4">Acciones rápidas</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

                <a href="{{ route('admin.usuarios.create') }}" 
                   class="bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow">
                   <span class="text-2xl">➕</span> Crear nuevo usuario
                </a>

                <a href="{{ route('admin.reportes.generar') }}" 
                   class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow">
                   <span class="text-2xl">🧾</span> Generar reporte
                </a>

                <a href="{{ route('admin.anuncios.enviar') }}" 
                   class="bg-pink-100 hover:bg-pink-200 text-pink-700 font-semibold py-4 px-5 rounded-lg flex justify-center items-center gap-3 transition shadow">
                   <span class="text-2xl">📤</span> Enviar anuncio
                </a>

            </div>
        </section>

        {{-- 3. Alertas / Notificaciones --}}
        <section>
            <h2 class="text-2xl font-semibold mb-4">Alertas / Notificaciones</h2>
            <ul class="bg-white shadow rounded-xl p-6 space-y-3 max-h-56 overflow-y-auto">
                <li class="flex items-center gap-3 text-red-600 font-semibold">
                    🔴 <span>Usuario <strong>Juan Pérez</strong> lleva 10 días inactivo</span>
                </li>
                <li class="flex items-center gap-3 text-yellow-600 font-semibold">
                    ⚠️ <span>Grupo <strong>"Equipo Norte"</strong> sin entrenador asignado</span>
                </li>
                <li class="flex items-center gap-3 text-green-600 font-semibold">
                    ✅ <span>Se completó la exportación del reporte de progreso</span>
                </li>
                {{-- Puedes agregar alertas dinámicas aquí --}}
            </ul>
        </section>

        {{-- 4. Actividad reciente --}}
        <section>
            <h2 class="text-2xl font-semibold mb-4">Actividad reciente</h2>
            <div class="bg-white shadow rounded-xl p-6 max-h-80 overflow-y-auto space-y-4">
                <div>
                    <h3 class="font-semibold">Usuarios registrados recientemente</h3>
                    <ul class="list-disc list-inside text-gray-700 mt-2">
                        <li>María Gómez - 2025-05-18</li>
                        <li>Carlos Ruiz - 2025-05-17</li>
                        <li>Lucía Fernández - 2025-05-16</li>
                        {{-- Reemplaza por datos dinámicos --}}
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold">Cambios hechos por otros admins</h3>
                    <ul class="list-disc list-inside text-gray-700 mt-2">
                        <li>Juan Pérez actualizó el perfil de Ana López</li>
                        <li>María Gómez creó un nuevo grupo "Equipo Sur"</li>
                        {{-- Reemplaza por datos dinámicos --}}
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold">Últimos contenidos publicados</h3>
                    <ul class="list-disc list-inside text-gray-700 mt-2">
                        <li>Nuevo entrenamiento HIIT - 2025-05-15</li>
                        <li>Blog: Alimentación saludable - 2025-05-14</li>
                        {{-- Reemplaza por datos dinámicos --}}
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
                    <div class="bg-gray-100 rounded p-10 text-center text-gray-500">[Gráfico línea o barras aquí]</div>
                </div>

                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="font-semibold mb-3">Actividad por grupo o entrenador</h3>
                    <div class="bg-gray-100 rounded p-10 text-center text-gray-500">[Gráfico de barras aquí]</div>
                </div>

                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="font-semibold mb-3">Distribución de usuarios por rol</h3>
                    <div class="bg-gray-100 rounded p-10 text-center text-gray-500">[Gráfico circular o torta aquí]</div>
                </div>

            </div>
        </section>
    </div>
</x-app-layout>
