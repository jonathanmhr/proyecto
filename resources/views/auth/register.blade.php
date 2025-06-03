<x-guest-layout>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 to-white px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-xl space-y-8">

            {{-- Logo --}}
            <div class="flex justify-center">
                <x-authentication-card-logo />
            </div>

            {{-- Título --}}
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Crear una cuenta</h2>
                <p class="mt-2 text-sm text-gray-600">Empieza a disfrutar de nuestros servicios registrándote.</p>
            </div>

            {{-- Formulario --}}
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                {{-- Nombre --}}
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        {{-- User Icon --}}
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A7 7 0 0112 15a7 7 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <input id="name" name="name" type="text" required autofocus
                        class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Tu nombre completo" value="{{ old('name') }}">
                </div>

                {{-- Correo --}}
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        {{-- Email Icon --}}
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12l-4-4-4 4m0 0l4 4 4-4m-4-4v8" />
                        </svg>
                    </div>
                    <input id="email" name="email" type="email" required
                        class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="ejemplo@correo.com" value="{{ old('email') }}">
                </div>

                {{-- Contraseña --}}
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        {{-- Lock Icon --}}
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c1.657 0 3 1.343 3 3v1H9v-1c0-1.657 1.343-3 3-3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11h14v10H5z" />
                        </svg>
                    </div>
                    <input id="password" name="password" type="password" required
                        class="pl-10 pr-10 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="********">
                    {{-- Eye Toggle --}}
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
                        onclick="togglePassword('password')">
                        <svg id="icon-password" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>

                {{-- Confirmar contraseña --}}
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        {{-- Lock Icon --}}
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c1.657 0 3 1.343 3 3v1H9v-1c0-1.657 1.343-3 3-3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11h14v10H5z" />
                        </svg>
                    </div>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="pl-10 pr-10 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="********">
                    {{-- Eye Toggle --}}
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
                        onclick="togglePassword('password_confirmation')">
                        <svg id="icon-password_confirmation" class="w-5 h-5 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>

                {{-- reCAPTCHA --}}
                <div class="flex justify-center"> {{-- Añadido para centrar el reCAPTCHA --}}
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.sitekey') }}" data-theme="light">
                        {{-- Puedes cambiar "light" por "dark" si tu diseño lo requiere --}}
                    </div>
                </div>
                @if ($errors->has('g-recaptcha-response'))
                    <span class="text-sm text-red-600 text-center block">{{ $errors->first('g-recaptcha-response') }}</span>
                @endif

                {{-- Botón Registrar --}}
                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Registrarse
                    </button>
                </div>
            </form>

            {{-- Link a login --}}
            <div class="text-center mt-4 text-sm">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">Iniciar
                    sesión</a>
            </div>

            {{-- Botón Google --}}
            <div class="mt-4">
                <a href="{{ route('auth.google.redirect') }}"
                    class="inline-flex items-center justify-center w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    {{-- Google Icon --}}
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                        <path fill="#EA4335"
                            d="M12 11.5v3.6h5.3c-.2 1.4-1.6 4-5.3 4-3.2 0-5.8-2.7-5.8-6s2.6-6 5.8-6c1.8 0 3 0.8 3.7 1.5l2.5-2.5C16.1 5.1 14.2 4.2 12 4.2 7.5 4.2 4 7.7 4 12.3s3.5 8.1 8 8.1c4.6 0 7.6-3.2 7.6-7.8 0-.5 0-.8-.1-1.2H12z" />
                    </svg>
                    Registrarse con Google
                </a>
            </div>
        </div>
    </div>

    {{-- JS Toggle Password --}}
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</x-guest-layout>