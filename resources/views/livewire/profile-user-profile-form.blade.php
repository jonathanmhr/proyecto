<x-form-section submit="save">
    <x-slot name="title">
        <h2 class="text-white">
            {{ __('Perfil extendido') }}
        </h2>
    </x-slot>

    <x-slot name="description">
        <h4 class="text-white">
            {{ __('Actualiza tus datos adicionales del perfil.') }}
        </h4>
    </x-slot>

    <x-slot name="form">
        @if (session()->has('message'))
            <div class="col-span-6">
                <p class="text-sm text-green-600">{{ session('message') }}</p>
            </div>
        @endif

        {{-- Mostrar fecha_nacimiento solo si NO existe perfil --}}
        @unless($perfilExiste)
        <div class="col-span-6 sm:col-span-4">
            <x-label for="fecha_nacimiento" value="{{ __('Fecha de nacimiento') }}" />
            <x-input 
                id="fecha_nacimiento" 
                type="date" 
                class="mt-1 block w-full" 
                wire:model.defer="fecha_nacimiento" 
            />
            <x-input-error for="fecha_nacimiento" class="mt-2" />
        </div>
        @endunless

        <div class="col-span-6 sm:col-span-4">
            <x-label for="peso" value="{{ __('Peso (kg)') }}" />
            <x-input 
                id="peso" 
                type="number" 
                step="0.1" 
                min="1" 
                max="300" 
                class="mt-1 block w-full" 
                wire:model.defer="peso" 
            />
            <x-input-error for="peso" class="mt-2" />
        </div>

        {{-- Mostrar altura solo si NO existe perfil --}}
        @unless($perfilExiste)
        <div class="col-span-6 sm:col-span-4">
            <x-label for="altura" value="{{ __('Altura (cm)') }}" />
            <x-input 
                id="altura" 
                type="number" 
                step="0.1" 
                min="30" 
                max="250" 
                class="mt-1 block w-full" 
                wire:model.defer="altura" 
            />
            <x-input-error for="altura" class="mt-2" />
        </div>
        @endunless

        <div class="col-span-6 sm:col-span-4">
            <x-label for="objetivo" value="{{ __('Objetivo') }}" />
            <x-input 
                id="objetivo" 
                type="text" 
                class="mt-1 block w-full" 
                wire:model.defer="objetivo" 
            />
            <x-input-error for="objetivo" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="id_nivel" value="{{ __('Nivel') }}" />
            <select 
                id="id_nivel" 
                class="form-select mt-1 block w-full" 
                wire:model.defer="id_nivel"
            >
                <option value="">{{ __('Seleccione nivel') }}</option>
                <option value="1">{{ __('Básico') }}</option>
                <option value="2">{{ __('Intermedio') }}</option>
                <option value="3">{{ __('Avanzado') }}</option>
            </select>
            <x-input-error for="id_nivel" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Guardado.') }}
        </x-action-message>

        <x-button>
            {{ __('Guardar') }}
        </x-button>
    </x-slot>
</x-form-section>
