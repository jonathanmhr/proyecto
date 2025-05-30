<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 to-white px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-xl space-y-8">
            
            {{-- Logo --}}
            <div class="flex justify-center">
                <x-authentication-card-logo class="h-16 w-auto" />
            </div>

            {{-- Título --}}
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-800">Bienvenido de nuevo</h2>
                <p class="mt-2 text-sm text-gray-500">Inicia sesión con tus credenciales</p>
            </div>

            {{-- Mensajes de error --}}
            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm text-center">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Formulario --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            {{-- Icono correo --}}
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 12H8m8 0a4 4 0 00-8 0m8 0v1a4 4 0 01-8 0v-1m16 8a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2h16a2 2 0 012 2v14z"/>
                            </svg>
                        </span>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="ejemplo@correo.com" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            {{-- Icono candado --}}
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-7a2 2 0 00-2-2H6a2 2 0 00-2 2v7a2 2 0 002 2zm6-10a4 4 0 00-4-4 4 4 0 018 0v2" />
                            </svg>
                        </span>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="********">
                    </div>
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Recuérdame y enlace contraseña --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        <span class="ml-2">Recuérdame</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>

                {{-- Botón login --}}
                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-semibold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Iniciar sesión
                    </button>
                </div>
            </form>

            {{-- Línea divisoria --}}
            <div class="flex items-center justify-center gap-2 text-gray-400 text-sm">
                <hr class="flex-grow border-gray-300"> o <hr class="flex-grow border-gray-300">
            </div>

            {{-- Login con Google --}}
            <div class="text-center">
                <a href="{{ route('auth.google.redirect') }}"
                    class="inline-flex items-center justify-center w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none">
                        <path fill="#EA4335"
                            d="M12 11.5v3.6h5.3c-.2 1.4-1.6 4-5.3 4-3.2 0-5.8-2.7-5.8-6s2.6-6 5.8-6c1.8 0 3 0.8 3.7 1.5l2.5-2.5C16.1 5.1 14.2 4.2 12 4.2 7.5 4.2 4 7.7 4 12.3s3.5 8.1 8 8.1c4.6 0 7.6-3.2 7.6-7.8 0-.5 0-.8-.1-1.2H12z" />
                    </svg>
                    Iniciar sesión con Google
                </a>
            </div>

            {{-- Registro --}}
            <div class="text-center mt-6 text-sm text-gray-600">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:text-indigo-500">
                    Crear una cuenta
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
