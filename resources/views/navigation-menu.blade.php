<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Contenedor principal de navegación -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>
            </div>

            <!-- Hamburguesa -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menú responsive (hamburguesa) -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:block">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Enlaces del menú -->
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <!-- Enlaces visibles solo para el rol de admin -->
            @can('admin-access')
                <x-responsive-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')">
                    {{ __('Administración') }}
                </x-responsive-nav-link>
            @endcan

            <!-- Enlaces visibles solo para el rol de entrenador -->
            @can('entrenador-access')
                <x-responsive-nav-link href="{{ route('entrenador.dashboard') }}" :active="request()->routeIs('entrenador.*')">
                    {{ __('Panel Entrenador') }}
                </x-responsive-nav-link>
            @endcan

            <x-responsive-nav-link href="{{ route('entrenador.clases.index') }}" :active="request()->routeIs('entrenador.clases.*')">
                {{ __('Clases') }}
            </x-responsive-nav-link>

            <!-- Enlace para crear clases, visible para admin_entrenador o entrenador -->
            @canany(['admin_entrenador', 'entrenador-access'])
                <x-responsive-nav-link href="{{ route('entrenador.clases.create') }}" :active="request()->routeIs('entrenador.clases.create')">
                    {{ __('Crear Clase') }}
                </x-responsive-nav-link>
            @endcanany

            <!-- Configuración de usuario -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="shrink-0 me-3">
                            <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                                 alt="{{ Auth::user()->name }}" />
                        </div>
                    @endif

                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Perfil -->
                    <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                            {{ __('API Tokens') }}
                        </x-responsive-nav-link>
                    @endif

                    <!-- Cerrar sesión -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf

                        <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
