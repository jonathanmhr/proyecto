<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight py-3 px-4 rounded-md shadow-md" style="background-color: #111828;">
            {{ __('Editar Usuario: ') }} <strong class="text-red-500">{{ $user->name }}</strong>
        </h2>
    </x-slot>

    {{-- Contenedor principal con el fondo azul oscuro #111828 --}}
    <div class="min-h-screen py-8" style="background-color: #111828;">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Botón de volver a la lista de usuarios --}}
            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md shadow-sm transition ease-in-out duration-150 mb-6"
               aria-label="Volver a la lista de usuarios">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                {{ __('Volver a la lista de usuarios') }}
            </a>

            {{-- Mensaje de éxito (opcional) --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">{{ __('¡Éxito!') }}</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 1.697L10 11.697l-2.651 2.651a1.2 1.2 0 1 1-1.697-1.697L8.303 10 5.652 7.349a1.2 1.2 0 1 1 1.697-1.697L10 8.303l2.651-2.651a1.2 1.2 0 1 1 1.697 1.697L11.697 10l2.651 2.651z"/></svg>
                    </span>
                </div>
            @endif

            {{-- Contenedor del formulario con el fondo azul oscuro #111828 --}}
            <div class="shadow-xl rounded-lg p-6 lg:p-8 text-white" style="background-color: #111828;">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Campo Nombre --}}
                        <div>
                            <label for="name" class="block text-gray-300 text-sm font-bold mb-2">
                                {{ __('Nombre') }}:
                            </label>
                            <input type="text" name="name" id="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror"
                                   style="background-color: #2a313b; color: #ffffff; border-color: #3b424d;" {{-- Estos colores son de la paleta original para los inputs --}}
                                   required autocomplete="name">
                            @error('name')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Campo Email --}}
                        <div>
                            <label for="email" class="block text-gray-300 text-sm font-bold mb-2">
                                {{ __('Email') }}:
                            </label>
                            <input type="email" name="email" id="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                                   style="background-color: #2a313b; color: #ffffff; border-color: #3b424d;" {{-- Estos colores son de la paleta original para los inputs --}}
                                   required autocomplete="email">
                            @error('email')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Campo Rol --}}
                        <div class="col-span-full">
                            <label for="role" class="block text-gray-300 text-sm font-bold mb-2">
                                {{ __('Rol') }}:
                            </label>
                            <select name="role" id="role"
                                    class="shadow border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline @error('role') border-red-500 @enderror"
                                    style="background-color: #2a313b; color: #ffffff; border-color: #3b424d;" {{-- Estos colores son de la paleta original para los inputs --}}
                                    required>
                                <option value="admin" {{ $user->isAn('admin') ? 'selected' : '' }}>{{ __('Admin') }}</option>
                                <option value="admin_entrenador" {{ $user->isAn('admin_entrenador') ? 'selected' : '' }}>{{ __('Admin Entrenador') }}</option>
                                <option value="entrenador" {{ $user->isAn('entrenador') ? 'selected' : '' }}>{{ __('Entrenador') }}</option>
                                <option value="cliente" {{ $user->isA('cliente') ? 'selected' : '' }}>{{ __('Cliente') }}</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end mt-8 pt-4 border-t" style="border-color: #3b424d;"> {{-- Borde con un color similar a los inputs --}}
                        {{-- Botón Cancelar --}}
                        <a href="{{ route('admin.users.index') }}"
                           class="px-5 py-2 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150 mr-3"
                           style="background-color: #2a313b;"> {{-- Fondo similar a los inputs para el botón Cancelar --}}
                            {{ __('Cancelar') }}
                        </a>
                        {{-- Botón Guardar cambios --}}
                        <button type="submit"
                                class="px-5 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150">
                            {{ __('Guardar cambios') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>