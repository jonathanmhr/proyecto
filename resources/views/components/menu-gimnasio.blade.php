<div {{ $attributes->merge(['class' => 'flex flex-col sm:flex-row space-y-1 sm:space-y-0 sm:space-x-8']) }}>
    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>

    @can('admin-access')
        <x-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')">
            {{ __('Administración') }}
        </x-nav-link>
    @endcan

    @can('entrenador-access')
        <x-nav-link href="{{ route('entrenador.dashboard') }}" :active="request()->routeIs('entrenador.*')">
            {{ __('Panel Entrenador') }}
        </x-nav-link>
    @endcan

    <x-nav-link href="{{ route('entrenador.clases.index') }}" :active="request()->routeIs('entrenador.clases.*')">
        {{ __('Clases') }}
    </x-nav-link>

    @canany(['admin_entrenador', 'entrenador-access'])
        <x-nav-link href="{{ route('entrenador.clases.create') }}" :active="request()->routeIs('entrenador.clases.create')">
            {{ __('Crear Clase') }}
        </x-nav-link>
    @endcanany
</div>
