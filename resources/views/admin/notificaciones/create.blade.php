<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-6">

        <!-- Encabezado -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Enviar Notificación</h1>
            <div class="flex space-x-3">
                <a href="{{ route('admin.notificaciones.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                    Cancelar
                </a>
                <button form="formEnviarNotificacion" type="submit"
                    class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Enviar
                </button>
            </div>
        </div>

        <!-- Formulario -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form id="formEnviarNotificacion" action="{{ route('admin.notificaciones.send') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Título -->
                <div>
                    <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                    <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}"
                           class="block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Título de la notificación" required>
                    @error('titulo')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mensaje -->
                <div>
                    <label for="mensaje" class="block text-sm font-medium text-gray-700 mb-1">Mensaje</label>
                    <textarea name="mensaje" id="mensaje" rows="5"
                              class="block w-full rounded-md border-gray-300 px-4 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Escribe aquí el mensaje..." required>{{ old('mensaje') }}</textarea>
                    @error('mensaje')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipo de envío -->
                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo de envío</label>
                    <select id="tipo" name="tipo" required
                            class="block w-full sm:w-1/3 rounded-md border-gray-300 px-4 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="notificacion" {{ old('tipo') == 'notificacion' ? 'selected' : '' }}>Solo Notificación</option>
                        <option value="email" {{ old('tipo') == 'email' ? 'selected' : '' }}>Notificación + Email</option>
                    </select>
                    @error('tipo')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Destino -->
                <div x-data="{ destino: '{{ old('destino', 'todos') }}' }" class="space-y-4">
                    <label class="block text-sm font-medium text-gray-700">Enviar a:</label>
                    <div class="flex flex-wrap gap-6">
                        <label class="inline-flex items-center">
                            <input type="radio" name="destino" value="todos" x-model="destino" required class="text-blue-600">
                            <span class="ml-2 text-gray-700">Todos los usuarios</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="destino" value="roles" x-model="destino" class="text-blue-600">
                            <span class="ml-2 text-gray-700">Usuarios por Roles</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="destino" value="usuarios" x-model="destino" class="text-blue-600">
                            <span class="ml-2 text-gray-700">Usuarios específicos</span>
                        </label>
                    </div>
                    @error('destino')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Roles -->
                    <div x-show="destino === 'roles'" x-cloak
                         class="mt-4 p-4 bg-gray-50 border border-gray-200 rounded-md max-h-56 overflow-y-auto">
                        <p class="font-semibold text-gray-800 mb-3">Selecciona roles:</p>
                        <div class="flex flex-wrap gap-4">
                            @foreach($roles as $role)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                           @if(is_array(old('roles')) && in_array($role->name, old('roles'))) checked @endif
                                           class="text-blue-600">
                                    <span class="ml-2 capitalize text-gray-700">{{ $role->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('roles')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Usuarios específicos -->
                    <div x-show="destino === 'usuarios'" x-cloak
                         class="mt-4 p-4 bg-gray-50 border border-gray-200 rounded-md max-h-72 overflow-y-auto">
                        <p class="font-semibold text-gray-800 mb-3">Selecciona usuarios:</p>
                        @if($usuarios->count())
                            <div class="space-y-2">
                                @foreach($usuarios as $usuario)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="usuarios[]" value="{{ $usuario->id }}"
                                               @if(is_array(old('usuarios')) && in_array($usuario->id, old('usuarios'))) checked @endif
                                               class="text-blue-600">
                                        <span class="ml-2 text-gray-700">{{ $usuario->name }}
                                            <small class="text-gray-500">({{ $usuario->email }})</small>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <div class="mt-4">
                                {{ $usuarios->links() }}
                            </div>
                        @else
                            <p class="text-gray-600 italic">No hay usuarios disponibles.</p>
                        @endif
                        @error('usuarios')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
