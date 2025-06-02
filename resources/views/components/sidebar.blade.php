<aside x-data="{ open: window.innerWidth >= 768, hasNewNotification: false }"
    @resize.window="open = window.innerWidth >= 768" {{-- Agregamos un listener para el resize de la ventana --}}
    class="fixed top-0 left-0 h-full transition-all duration-300 bg-gray-900 shadow-lg flex flex-col py-4 z-50
           md:w-64 md:items-start md:top-4 md:left-4 md:h-[calc(100vh-2rem)] md:rounded-xl"
    :class="open ? 'w-64 items-start' : 'w-20 items-center'">

    {{-- Botón para abrir/cerrar en pantallas pequeñas --}}

    {{-- Overlay para pantallas pequeñas cuando el sidebar está abierto --}}
    <div x-show="open" x-cloak @click="open = false" class="fixed inset-0 bg-black opacity-50 z-40 md:hidden"></div>


    <div class="mb-6" :class="open ? 'px-4' : 'px-0'">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" :width="open ? '150px' : '40px'" alt="logo" class="mx-auto">
        </a>
    </div>

    <nav class="flex-1 w-full space-y-2 px-2 text-gray-300">
        {{-- Importante: El x-sidebar-link tendrá que ajustar sus propios colores --}}
        <x-sidebar-link icon="user" route="dashboard" label="Mi Perfil" />

        {{-- ADMIN --}}
        @can('admin-access')
            <x-sidebar-link icon="shield" route="admin.dashboard" label="Panel de Admin" />
        @endcan

        {{-- ADMIN ENTRENADOR --}}
        @can('admin_entrenador')
            <div x-data="{ openAdminEntrenador: false }" class="w-full">
                <button @click="openAdminEntrenador = !openAdminEntrenador"
                    class="flex items-center gap-3 w-full text-gray-300 hover:bg-orange-700 hover:text-red-500 px-3 py-2 rounded-lg text-sm transition-all"
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
                    class="flex items-center gap-3 w-full text-gray-300 hover:bg-orange-700 hover:text-red-500 px-3 py-2 rounded-lg text-sm transition-all"
                    :class="open ? 'justify-start' : 'justify-center'">
                    <i data-feather="briefcase" class="w-5 h-5"></i>
                    <span x-show="open" x-cloak class="ml-2 transition-opacity duration-200">Entrenador</span>
                    <i data-feather="chevron-down" class="ml-auto" x-show="open"></i>
                </button>

                <div x-show="open && openEntrenador" x-cloak x-transition class="ml-6 mt-1 space-y-1 text-gray-300">
                    <x-sidebar-link icon="layout" route="entrenador.dashboard" label="Panel General" />
                </div>
            </div>
        @endcan

        {{-- CLIENTE --}}
        @can('cliente-access')
            <x-sidebar-link icon="shopping-bag" route="tienda.index" label="Tienda" />
        @endcan

        @can('cliente-access')
            <x-sidebar-link icon="shopping-bag" route="compras.index" label="Mis pedidos" />
        @endcan

        {{-- COMÚN A VARIOS ROLES --}}
        @canany(['cliente-access', 'entrenador-access', 'admin_entrenador'])
            <x-sidebar-link icon="calendar" route="cliente.dashboard" label="Clases Disponibles" />
            {{-- <x-sidebar-link icon="message-circle" route="#" label="Mensajes" /> --}}
        @endcan
    </nav>

    @php
        $notificacionesNoLeidas = auth()->user()->unreadNotifications()->count();
        $badgeCount = $notificacionesNoLeidas > 9 ? '+9' : $notificacionesNoLeidas;
    @endphp

    <div class="w-full px-2 mb-4" x-data="{ notificaciones: {{ $notificacionesNoLeidas }} }">
        <template x-if="notificaciones > 0">
            <a href="{{ route('entrenador.dashboard') }}"
                class="flex items-center gap-3 w-full text-gray-300 hover:bg-orange-700 hover:text-red-500 px-3 py-2 rounded-lg text-sm transition-all relative"
                :class="open ? 'justify-start' : 'justify-center'" title="Notificaciones">
                <div class="relative">
                    <i data-feather="bell" class="w-5 h-5"></i>

                    <span
                        class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full"
                        style="min-width: 1.25rem; height: 1.25rem; line-height: 1.25rem;">
                        {{ $badgeCount }}
                    </span>
                </div>

                <span x-show="open" x-cloak class="ml-2 transition-opacity duration-200">Notificaciones</span>
            </a>
        </template>
    </div>

    <div class="w-full px-2">
        <a href="{{ route('profile.show') }}"
            class="flex items-center gap-3 w-full text-gray-300 hover:bg-orange-700 hover:text-red-500 px-3 py-2 rounded-lg text-sm transition-all"
            :class="open ? 'justify-start' : 'justify-center'">
            <i data-feather="settings" class="w-5 h-5"></i>
            <span x-show="open" x-cloak class="ml-2 transition-opacity duration-200">Ajustes</span>
        </a>

        <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf
            <button type="submit"
                class="flex items-center gap-3 w-full text-gray-300 hover:bg-red-700 hover:text-red-500 px-3 py-2 rounded-lg text-sm transition-all"
                :class="open ? 'justify-start' : 'justify-center'">
                <i data-feather="log-out" class="w-5 h-5"></i>
                <span x-show="open" x-cloak class="ml-2 transition-opacity duration-200">Cerrar sesión</span>
            </button>
        </form>
    </div>

</aside>