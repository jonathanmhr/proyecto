<aside x-data="{ open: false, hasNewNotification: false }" x-init="feather.replace()"
    class="fixed top-4 left-4 h-[calc(100vh-2rem)] transition-all duration-300 bg-gray-100 rounded-xl shadow-md flex flex-col items-center py-4 z-50"
    :class="open ? 'w-64 items-start' : 'w-20 items-center'" @mouseenter="open = true" @mouseleave="open = false">

    <!-- Logo -->
    <div class="mb-6">
        <a href="{{ route('dashboard') }}">
            <x-application-mark class="h-8 w-auto" />
        </a>
    </div>

    <!-- Navegación principal -->
    <nav class="flex-1 w-full space-y-2 px-2 text-gray-700">

        <x-sidebar-link icon="user" route="dashboard" label="Mi Perfil" />

        {{-- ADMIN --}}
        @can('admin-access')
            <x-sidebar-link icon="shield" route="admin.dashboard" label="Panel de Admin" />
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

                <div x-show="open && openEntrenador" x-cloak x-transition class="ml-6 mt-1 space-y-1 text-gray-600">
                    <x-sidebar-link icon="layout" route="entrenador.dashboard" label="Panel General" />
                </div>
            </div>
        @endcan

        {{-- CLIENTE --}}
        @can('cliente-access')
            <x-sidebar-link icon="shopping-bag" route="entrenador.clases.index" label="Mis Suscripciones" />
        @endcan

        {{-- COMÚN A VARIOS ROLES --}}
        @canany(['cliente-access', 'entrenador-access', 'admin_entrenador'])
            <x-sidebar-link icon="calendar" route="cliente.dashboard" label="Clases Disponibles" />
            <x-sidebar-link icon="message-circle" route="cliente.clases.index" label="Comunidad" />
        @endcan
    </nav>

    <!-- Notificaciones simplificado (antes de Ajustes) -->
    @php
        $notificacionesNoLeidas = auth()->user()->unreadNotifications()->count();
        $badgeCount = $notificacionesNoLeidas > 9 ? '+9' : $notificacionesNoLeidas;
    @endphp

    <div class="w-full px-2 mb-4" x-data>
        <!-- Mostrar campana solo si hay notificaciones -->
        <template x-if="{{ $notificacionesNoLeidas }} > 0">
            <a href="{{ route('entrenador.dashboard') }}"
                class="flex items-center gap-3 w-full text-gray-600 hover:bg-blue-100 hover:text-blue-600 px-3 py-2 rounded-lg text-sm transition-all relative"
                :class="open ? 'justify-start' : 'justify-center'" title="Notificaciones">
                <div class="relative">
                    <i data-feather="bell" class="w-5 h-5"></i>

                    <span
                        class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-500 rounded-full"
                        style="min-width: 1.25rem; height: 1.25rem; line-height: 1.25rem;"
                        x-text="'{{ $badgeCount }}'"></span>
                </div>

                <span x-show="open" x-cloak class="ml-2 transition-opacity duration-200">Notificaciones</span>
            </a>
        </template>
    </div>


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
