<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Panel de Administración Total
        </h2>
    </x-slot>

    <div class="py-10 px-4 max-w-7xl mx-auto space-y-6">
        
        {{-- 🔐 Gestión de Usuarios --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-lg font-bold mb-2">🔐 Gestión de Usuarios</h3>
            <ul class="list-disc list-inside text-gray-700">
                <li>Lista completa de usuarios (con filtros por rol, estado, etc.)</li>
                <li>Creación, edición y eliminación de usuarios</li>
                <li>Asignación y edición de roles (entrenador, admin parcial, etc.)</li>
                <li>Acciones masivas sobre usuarios (cambiar roles, activar/desactivar cuentas)</li>
                <li>Historial de actividad por usuario</li>
                <li>Impersonar usuario (entrar como otro usuario para soporte)</li>
            </ul>
        </div>

        {{-- 🧑‍🏫 Gestión de Entrenadores / Admins --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-lg font-bold mb-2">🧑‍🏫 Gestión de Entrenadores / Admins</h3>
            <ul class="list-disc list-inside text-gray-700">
                <li>Ver y editar entrenadores</li>
                <li>Asignar entrenadores a grupos o usuarios</li>
                <li>Ver estadísticas o rendimiento por entrenador</li>
                <li>Ver qué usuarios están asignados a qué entrenador</li>
            </ul>
        </div>

        {{-- 🗂️ Gestión de Contenidos / Recursos --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-lg font-bold mb-2">🗂️ Gestión de Contenidos / Recursos</h3>
            <ul class="list-disc list-inside text-gray-700">
                <li>Crear, editar y eliminar recursos del sistema (ej. entrenamientos, módulos, tareas)</li>
                <li>Subida de documentos, videos o archivos multimedia</li>
                <li>Control de visibilidad y acceso por usuario o grupo</li>
                <li>Versionado de contenido</li>
            </ul>
        </div>

        {{-- 🏋️ Gestión de Grupos / Equipos --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-lg font-bold mb-2">🏋️ Gestión de Grupos / Equipos</h3>
            <ul class="list-disc list-inside text-gray-700">
                <li>Crear y modificar grupos de usuarios</li>
                <li>Asignar entrenadores y contenidos por grupo</li>
                <li>Ver estadísticas agregadas por grupo</li>
            </ul>
        </div>

        {{-- 📊 Panel de Estadísticas / Reportes --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-lg font-bold mb-2">📊 Panel de Estadísticas / Reportes</h3>
            <ul class="list-disc list-inside text-gray-700">
                <li>Métricas generales (usuarios activos, progreso, uso por día/semana)</li>
                <li>Reportes por usuario, grupo o entrenador</li>
                <li>Exportación de datos (CSV, PDF)</li>
                <li>Alertas de inactividad, retrasos o anomalías</li>
            </ul>
        </div>

        {{-- 🛠️ Configuración del Sistema --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-lg font-bold mb-2">🛠️ Configuración del Sistema</h3>
            <ul class="list-disc list-inside text-gray-700">
                <li>Personalización de la plataforma (logo, colores, textos)</li>
                <li>Gestión de permisos por rol</li>
                <li>Configuración de notificaciones (email, app)</li>
                <li>Parámetros del sistema (fechas clave, umbrales, etc.)</li>
            </ul>
        </div>

        {{-- 🔔 Sistema de Notificaciones y Alertas --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-lg font-bold mb-2">🔔 Sistema de Notificaciones y Alertas</h3>
            <ul class="list-disc list-inside text-gray-700">
                <li>Ver notificaciones globales</li>
                <li>Enviar mensajes o anuncios masivos</li>
                <li>Alertas automáticas (usuarios inactivos, errores del sistema)</li>
            </ul>
        </div>

        {{-- 📝 Auditoría / Seguridad --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-lg font-bold mb-2">📝 Auditoría / Seguridad</h3>
            <ul class="list-disc list-inside text-gray-700">
                <li>Registro de todas las acciones importantes (logs de actividad)</li>
                <li>Gestión de accesos y sesiones</li>
                <li>Control de cambios y trazabilidad</li>
            </ul>
        </div>
    </div>
</x-app-layout>
