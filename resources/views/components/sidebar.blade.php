<aside x-data="{ open: false }" x-bind="$el"
    class="fixed top-4 left-4 h-[calc(100vh-2rem)] transition-all duration-300 bg-white rounded-xl shadow-md flex flex-col items-center py-4 z-50"
    :class="open ? 'w-64 items-start' : 'w-20 items-center'" @mouseenter="open = true" @mouseleave="open = false"
    x-init="$watch('open', () => feather.replace())">

    <!-- Logo -->
    <div class="mb-6">
        <a href="{{ route('dashboard') }}">
            <x-application-mark class="h-8 w-auto" />
        </a>
    </div>

    <!-- Navegación principal -->
    <nav class="flex-1 w-full space-y-2 px-2">

        <x-sidebar-link icon="home" route="dashboard" label="Dashboard" />

        {{-- ADMIN --}}
        @can('admin-access')
            <x-sidebar-link icon="shield" route="admin.users.index" label="Gestión de Usuarios" />
        @endcan

        {{-- ADMIN ENTRENADOR --}}
        @can('admin_entrenador')
            <div x-data="{ openAdminEntrenador: false }" class="w-full">
                <button @click="openAdminEntrenador = !openAdminEntrenador"
                    class="flex items-center gap-3 w-full text-gray-600 hover:bg-blue-100 hover:text-blue-600 px-3 py-2 rounded-lg text-sm transition-all"
                    :class="open ? 'justify-start' : 'justify-center'">
                    <i data-feather="briefcase" class="w-5 h-5"></i>
                    <span x-show="open" x-cloak class="ml-2 transition-opacity duration-200">Admin Entrenador</span>
                    <i data-feather="chevron-down" class="ml-auto" x-show="open"></i>
                </button>

                <div x-show="open && openAdminEntrenador" x-cloak x-transition class="ml-6 mt-1 space-y-1">
                    <x-sidebar-link icon="layout" route="admin-entrenador.dashboard" label="Panel General" />
                    {{-- Puedes agregar accesos rápidos aquí si quieres --}}
                </div>
            </div>
        @endcan

        {{-- ENTRENADOR --}}
        @can('entrenador-access')
            <div x-data="{ openEntrenador: false }" class="w-full">
                <button @click="openEntrenador = !openEntrenador"
                    class="flex items-center gap-3 w-full text-gray-600 hover:bg-blue-100 hover:text-blue-600 px-3 py-2 rounded-lg text-sm transition-all"
                    :class="open ? 'justify-start' : 'justify-center'">
                    <i data-feather="briefcase" class="w-5 h-5"></i>
                    <span x-show="open" x-cloak class="ml-2 transition-opacity duration-200">Entrenador</span>
                    <i data-feather="chevron-down" class="ml-auto" x-show="open"></i>
                </button>

                <div x-show="open && openEntrenador" x-cloak x-transition class="ml-6 mt-1 space-y-1">
                    <x-sidebar-link icon="layout" route="entrenador.dashboard" label="Panel General" />
                    <x-sidebar-link icon="file-text" route="entrenador.dashboard" label="Reportes" />
                    {{--
                    <x-sidebar-link icon="calendar" route="entrenador.clases.index" label="Mis Clases" />
                    <x-sidebar-link icon="users" route="entrenador.usuarios.index" label="Alumnos" />
                    <x-sidebar-link icon="bar-chart" route="entrenador.estadisticas.index" label="Estadísticas" />
                    <x-sidebar-link icon="bell" route="entrenador.notificaciones.index" label="Notificaciones" />
                    <x-sidebar-link icon="dollar-sign" route="entrenador.suscripciones.index" label="Suscripciones" />
                    <x-sidebar-link icon="file-text" route="entrenador.reportes.index" label="Reportes" />
                    --}}
                </div>
            </div>
        @endcan

        {{-- CLIENTE --}}
        @can('cliente-access')
            <x-sidebar-link icon="shopping-bag" route="entrenador.clases.index" label="Mis Suscripciones" />
        @endcan

        {{-- COMÚN A VARIOS ROLES --}}
        @canany(['cliente-access', 'entrenador-access', 'admin_entrenador'])
        <x-sidebar-link icon="calendar" route="cliente.clases.index" label="Clases Disponibles" />
            <x-sidebar-link icon="message-circle" route="cliente.clases.index" label="Comunidad" />
        @endcan
    </nav>

    <!-- Ajustes de perfil -->
    <div class="w-full px-2">
        <a href="{{ route('profile.show') }}"
            class="flex items-center gap-3 w-full text-gray-600 hover:bg-blue-100 hover:text-blue-600 px-3 py-2 rounded-lg text-sm transition-all"
            :class="open ? 'justify-start' : 'justify-center'">
            <i data-feather="settings" class="w-5 h-5"></i>
            <span x-show="open" x-cloak class="ml-2 transition-opacity duration-200">Ajustes</span>
        </a>

        <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf
            <button type="submit"
                class="flex items-center gap-3 w-full text-gray-600 hover:bg-red-100 hover:text-red-600 px-3 py-2 rounded-lg text-sm transition-all"
                :class="open ? 'justify-start' : 'justify-center'">
                <i data-feather="log-out" class="w-5 h-5"></i>
                <span x-show="open" x-cloak class="ml-2 transition-opacity duration-200">Cerrar sesión</span>
            </button>
        </form>
    </div>
</aside>
