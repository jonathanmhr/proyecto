<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-6">

        <div class="flex items-center justify-between mb-6">
            {{-- Título - Cambiado a texto blanco --}}
            <h1 class="text-2xl font-bold text-white">Enviar Notificación</h1>
            <div class="flex space-x-3">
                {{-- Botón Cancelar - Fondo gris oscuro con texto blanco --}}
                <a href="{{ route('admin.notificaciones.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-600 transition shadow">
                    Cancelar
                </a>
                {{-- Botón Enviar - Azul consistente --}}
                <button form="formEnviarNotificacion" type="submit"
                    class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition shadow">
                    Enviar
                </button>
            </div>
        </div>

        {{-- Contenedor del formulario - Fondo oscuro, sombra y borde --}}
        <div class="bg-gray-800 shadow-lg rounded-lg p-6 border border-gray-700">
            @if(session('success'))
                {{-- Mensaje de éxito - Fondo verde oscuro, texto verde claro --}}
                <div class="mb-6 p-4 bg-green-800 border border-green-600 text-green-300 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form id="formEnviarNotificacion" action="{{ route('admin.notificaciones.send') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    {{-- Etiqueta de texto claro --}}
                    <label for="titulo" class="block text-sm font-medium text-gray-300 mb-1">Título</label>
                    {{-- Input oscuro con borde y foco acorde --}}
                    <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}"
                           class="block w-full rounded-md border-gray-600 bg-gray-700 text-white px-4 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400"
                           placeholder="Título de la notificación" required>
                    {{-- Mensaje de error - Rojo más claro --}}
                    @error('titulo')
                        <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    {{-- Etiqueta de texto claro --}}
                    <label for="mensaje" class="block text-sm font-medium text-gray-300 mb-1">Mensaje</label>
                    {{-- Textarea oscuro con borde y foco acorde --}}
                    <textarea name="mensaje" id="mensaje" rows="5"
                              class="block w-full rounded-md border-gray-600 bg-gray-700 text-white px-4 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400"
                              placeholder="Escribe aquí el mensaje..." required>{{ old('mensaje') }}</textarea>
                    {{-- Mensaje de error - Rojo más claro --}}
                    @error('mensaje')
                        <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    {{-- Etiqueta de texto claro --}}
                    <label for="tipo" class="block text-sm font-medium text-gray-300 mb-1">Tipo de envío</label>
                    {{-- Select oscuro con borde y foco acorde --}}
                    <select id="tipo" name="tipo" required
                            class="block w-full sm:w-1/3 rounded-md border-gray-600 bg-gray-700 text-white px-4 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        {{-- Opciones del select también oscuras --}}
                        <option value="notificacion" class="bg-gray-700 text-white" {{ old('tipo') == 'notificacion' ? 'selected' : '' }}>Solo Notificación</option>
                        <option value="email" class="bg-gray-700 text-white" {{ old('tipo') == 'email' ? 'selected' : '' }}>Notificación + Email</option>
                    </select>
                    {{-- Mensaje de error - Rojo más claro --}}
                    @error('tipo')
                        <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div x-data="{ destino: '{{ old('destino', 'todos') }}' }" class="space-y-4">
                    {{-- Etiqueta de texto claro --}}
                    <label class="block text-sm font-medium text-gray-300">Enviar a:</label>
                    <div class="flex flex-wrap gap-6">
                        {{-- Radio buttons con texto claro --}}
                        <label class="inline-flex items-center">
                            <input type="radio" name="destino" value="todos" x-model="destino" required class="text-blue-600 bg-gray-700 border-gray-600 focus:ring-blue-500">
                            <span class="ml-2 text-gray-300">Todos los usuarios</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="destino" value="roles" x-model="destino" class="text-blue-600 bg-gray-700 border-gray-600 focus:ring-blue-500">
                            <span class="ml-2 text-gray-300">Usuarios por Roles</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="destino" value="usuarios" x-model="destino" class="text-blue-600 bg-gray-700 border-gray-600 focus:ring-blue-500">
                            <span class="ml-2 text-gray-300">Usuarios específicos</span>
                        </label>
                    </div>
                    {{-- Mensaje de error - Rojo más claro --}}
                    @error('destino')
                        <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                    @enderror

                    <div x-show="destino === 'roles'" x-cloak
                         class="mt-4 p-4 bg-gray-700 border border-gray-600 rounded-md max-h-56 overflow-y-auto"> {{-- Fondo oscuro para el contenedor de roles --}}
                        <p class="font-semibold text-gray-300 mb-3">Selecciona roles:</p> {{-- Texto más claro --}}
                        <div class="flex flex-wrap gap-4">
                            @foreach($roles as $role)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                           @if(is_array(old('roles')) && in_array($role->name, old('roles'))) checked @endif
                                           class="text-blue-600 bg-gray-600 border-gray-500 focus:ring-blue-500"> {{-- Checkbox oscuro --}}
                                    <span class="ml-2 capitalize text-gray-300">{{ $role->name }}</span> {{-- Texto más claro --}}
                                </label>
                            @endforeach
                        </div>
                        {{-- Mensaje de error - Rojo más claro --}}
                        @error('roles')
                            <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="destino === 'usuarios'" x-cloak
                         class="mt-4 p-4 bg-gray-700 border border-gray-600 rounded-md max-h-72 overflow-y-auto"> {{-- Fondo oscuro para el contenedor de usuarios --}}
                        <p class="font-semibold text-gray-300 mb-3">Selecciona usuarios:</p> {{-- Texto más claro --}}
                        @if($usuarios->count())
                            <div class="space-y-2">
                                @foreach($usuarios as $usuario)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="usuarios[]" value="{{ $usuario->id }}"
                                               @if(is_array(old('usuarios')) && in_array($usuario->id, old('usuarios'))) checked @endif
                                               class="text-blue-600 bg-gray-600 border-gray-500 focus:ring-blue-500"> {{-- Checkbox oscuro --}}
                                        <span class="ml-2 text-gray-300">{{ $usuario->name }} {{-- Texto más claro --}}
                                            <small class="text-gray-400">({{ $usuario->email }})</small> {{-- Texto un poco más claro --}}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <div class="mt-4 text-white"> {{-- Paginación con texto blanco --}}
                                {{ $usuarios->links() }}
                            </div>
                        @else
                            <p class="text-gray-400 italic">No hay usuarios disponibles.</p> {{-- Texto más claro --}}
                        @endif
                        {{-- Mensaje de error - Rojo más claro --}}
                        @error('usuarios')
                            <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>