<x-app-layout>
    <div class="container mx-auto px-4 py-8 bg-gray-900 min-h-screen shadow-inner">
        {{-- Título principal ahora dentro del contenido, adaptado para un mejor flujo visual --}}
        <h1 class="font-extrabold text-4xl text-white mb-8 animate-fade-in-down tracking-wide">
            👋 ¡Bienvenido de nuevo, <span class="text-red-500">{{ auth()->user()->name }}</span>!
        </h1>


        {{-- INICIO DEL SLIDER DE RECOMENDACIONES DE DIETA CON FORMATO DE TARJETAS --}}
        <div class="bg-gray-800 rounded-xl shadow-lg p-6 mb-8 border border-gray-700">
            <h2 class="text-2xl font-bold text-white mb-4 text-center">
                🍽️ Recomendaciones de Dieta Personalizadas
            </h2>
            <div id="dietSlider" class="relative overflow-hidden rounded-lg">
                <div class="flex transition-transform duration-500 ease-in-out" id="sliderContainer">
                    @forelse ($dietasRecomendadas as $dieta)
                        @php
                            $totalMacros = $dieta->carbohidratos_g + $dieta->proteinas_g + $dieta->grasas_g;

                            $carbsPct = $totalMacros > 0 ? round(($dieta->carbohidratos_g / $totalMacros) * 100) : 0;
                            $proteinPct = $totalMacros > 0 ? round(($dieta->proteinas_g / $totalMacros) * 100) : 0;
                            $fatPct = $totalMacros > 0 ? round(($dieta->grasas_g / $totalMacros) * 100) : 0;

                            $sum = $carbsPct + $proteinPct + $fatPct;
                            if ($sum != 100 && $totalMacros > 0) {
                                if ($carbsPct >= $proteinPct && $carbsPct >= $fatPct) {
                                    $carbsPct += 100 - $sum;
                                } elseif ($proteinPct >= $carbsPct && $proteinPct >= $fatPct) {
                                    $proteinPct += 100 - $sum;
                                } else {
                                    $fatPct += 100 - $sum;
                                }
                            }

                            // Imagen real si existe, si no fallback placeholder con texto
                            $imageUrl = $dieta->image_url
                                ? asset($dieta->image_url)
                                : 'https://placehold.co/150x150/7868E6/FFFFFF?text=' .
                                    urlencode(substr($dieta->nombre, 0, 10));
                        @endphp

                        {{-- Tarjeta individual --}}
                        <div class="w-full sm:w-1/2 lg:w-1/3 xl:w-1/4 flex-shrink-0 p-2">
                            <div
                                class="bg-gray-700 rounded-xl shadow-md p-4 flex flex-col items-center border border-gray-600">
                                <img src="{{ $imageUrl }}" alt="{{ $dieta->nombre }}"
                                    class="w-32 h-32 object-cover rounded-full mb-3 shadow-sm" loading="lazy" />
                                <h3 class="text-xl font-semibold text-white mb-2 text-center">{{ $dieta->nombre }}</h3>
                                <p class="text-gray-400 text-sm mb-3 text-center line-clamp-2">{{ $dieta->descripcion }}
                                </p>
                                <p class="text-gray-300 text-base mb-2">~{{ $dieta->calorias_diarias ?? 'N/A' }} kcal
                                </p>

                                {{-- Detalles de Macros --}}
                                <div class="text-sm space-y-1 w-full">
                                    <div class="flex items-center justify-between text-gray-300">
                                        <span class="flex items-center"><span
                                                class="w-2 h-2 rounded-full bg-purple-400 mr-2"></span> Carbs</span>
                                        <span class="font-semibold">{{ $dieta->carbohidratos_g }} g
                                            ({{ $carbsPct }}%)
                                        </span>
                                    </div>
                                    <div class="w-full h-2 bg-gray-600 rounded-full overflow-hidden">
                                        <div class="h-full bg-purple-500" style="width: {{ $carbsPct }}%;"></div>
                                    </div>

                                    <div class="flex items-center justify-between text-gray-300 mt-2">
                                        <span class="flex items-center"><span
                                                class="w-2 h-2 rounded-full bg-orange-400 mr-2"></span> Proteína</span>
                                        <span class="font-semibold">{{ $dieta->proteinas_g }} g
                                            ({{ $proteinPct }}%)</span>
                                    </div>
                                    <div class="w-full h-2 bg-gray-600 rounded-full overflow-hidden">
                                        <div class="h-full bg-orange-500" style="width: {{ $proteinPct }}%;"></div>
                                    </div>

                                    <div class="flex items-center justify-between text-gray-300 mt-2">
                                        <span class="flex items-center"><span
                                                class="w-2 h-2 rounded-full bg-pink-400 mr-2"></span> Grasa</span>
                                        <span class="font-semibold">{{ $dieta->grasas_g }} g
                                            ({{ $fatPct }}%)</span>
                                    </div>
                                    <div class="w-full h-2 bg-gray-600 rounded-full overflow-hidden">
                                        <div class="h-full bg-pink-500" style="width: {{ $fatPct }}%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 text-center w-full py-4">No hay recomendaciones de dieta disponibles en
                            este momento.</p>
                    @endforelse
                </div>

                {{-- Controles del Slider --}}
                <button id="prevSlide" aria-label="Slide anterior"
                    class="absolute top-1/2 left-4 -translate-y-1/2 bg-gray-900 bg-opacity-60 text-white p-3 rounded-full hover:bg-opacity-80 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500"
                    style="cursor: pointer;">
                    <i data-feather="chevron-left" class="w-6 h-6"></i>
                </button>
                <button id="nextSlide" aria-label="Slide siguiente"
                    class="absolute top-1/2 right-4 -translate-y-1/2 bg-gray-900 bg-opacity-60 text-white p-3 rounded-full hover:bg-opacity-80 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500"
                    style="cursor: pointer;">
                    <i data-feather="chevron-right" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        {{-- FIN DEL SLIDER DE RECOMENDACIONES DE DIETA --}}

        @if (session('incomplete_profile'))
            <div
                class="bg-red-600 text-white p-5 rounded-xl shadow-lg mb-6 flex items-center space-x-3 transform transition-all duration-300 hover:scale-105 animate-fade-in border border-red-700">
                <i data-feather="alert-triangle" class="w-6 h-6 flex-shrink-0"></i>
                <p class="font-medium text-lg">⚠️ ¡Tu perfil está incompleto! <a href="{{ route('perfil.completar') }}"
                        class="underline hover:text-white">Completa tus datos aquí.</a></p>
            </div>
        @endif

        @if ($incompleteProfile)
            <div id="profile-modal"
                class="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center z-50 p-4">
                <div
                    class="bg-gray-800 p-8 rounded-2xl shadow-xl max-w-md w-full border border-red-700 transform scale-95 animate-scale-in">
                    <h2 class="text-3xl font-bold text-red-500 mb-4 flex items-center space-x-2">
                        <i data-feather="user-x" class="w-7 h-7"></i> <span>¡Perfil Incompleto!</span>
                    </h2>
                    <p class="text-gray-300 mb-6 leading-relaxed">Para acceder a todas las funciones (clases,
                        entrenamientos personalizados), por favor, completa tus datos.</p>
                    <div class="flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('perfil.completar') }}"
                            class="bg-red-600 text-white px-6 py-3 rounded-full font-bold shadow-md hover:bg-red-700 transition-all duration-300 transform hover:scale-105 text-center">Completar
                            Perfil</a>
                        <button
                            class="bg-gray-600 text-white px-6 py-3 rounded-full font-bold shadow-md hover:bg-gray-700 transition-all duration-300 transform hover:scale-105 text-center"
                            onclick="closeModal()">Cerrar</button>
                    </div>
                </div>
            </div>
        @endif

        @if (session('status') && session('status_type') == 'success')
            <div
                class="flex items-center bg-green-700 text-white p-5 rounded-xl mb-6 shadow-lg animate-fade-in-right border border-green-800">
                <i data-feather="check-circle" class="w-6 h-6 mr-3 flex-shrink-0"></i>
                <span class="font-medium">{{ session('status') }}</span>
            </div>
        @endif

        @if (session('status') && session('status_type') == 'error')
            <div
                class="flex items-center bg-red-700 text-white p-5 rounded-xl mb-6 shadow-lg animate-fade-in-left border border-red-800">
                <i data-feather="x-circle" class="w-6 h-6 mr-3 flex-shrink-0"></i>
                <span class="font-medium">{{ session('status') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            <div
                class="bg-gradient-to-br from-blue-900 to-blue-700 p-8 rounded-3xl shadow-xl border border-blue-800 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group">
                <h2 class="text-2xl font-bold text-blue-200 mb-4 flex items-center gap-3">
                    <i data-feather="clock" class="w-7 h-7 text-blue-300 group-hover:rotate-6 transition-transform"></i>
                    Historial
                </h2>
                <p class="text-blue-100 mb-6 leading-relaxed text-sm opacity-90">Consulta tu historial de cambios y
                    actividad.</p>
                <a href="{{ route('cliente.perfil.historial') }}" {{-- RUTA CORREGIDA --}}
                    class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-blue-700 transition-all duration-300 shadow-md text-sm">
                    Ver Historial <i data-feather="arrow-right" class="inline-block ml-2 w-5 h-5"></i>
                </a>
            </div>

            <div
                class="bg-gradient-to-br from-green-900 to-green-700 p-8 rounded-3xl shadow-xl border border-green-800 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group">
                <h2 class="text-2xl font-bold text-green-200 mb-4 flex items-center gap-3">
                    <i data-feather="book-open"
                        class="w-7 h-7 text-green-300 group-hover:scale-110 transition-transform"></i> Clases
                </h2>
                @if ($clases->isEmpty())
                    <p class="text-white opacity-80 mb-6 text-sm animate-pulse">No estás inscrito en clases.</p>
                @else
                    <div
                        class="transition-all duration-500 ease-in-out max-h-0 overflow-hidden opacity-0 group-hover:max-h-96 group-hover:opacity-100 mt-4">
                        @foreach ($clases as $clase)
                            <div class="border-b border-green-600 pb-3 mb-3 last:border-b-0">
                                <div class="text-white font-semibold text-lg">{{ $clase->nombre }}</div>
                                <div class="text-sm text-green-100 opacity-90">{{ $clase->descripcion }}</div>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-green-100 mt-4 text-xs opacity-90 group-hover:hidden animate-fade-in-up">Pasa el
                        ratón para ver tus clases.</p>
                @endif
            </div>

            <div
                class="bg-gradient-to-br from-purple-900 to-purple-700 p-8 rounded-3xl shadow-xl border border-purple-800 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group">
                <h2 class="text-2xl font-bold text-purple-200 mb-4 flex items-center gap-3">
                    <i data-feather="activity"
                        class="w-7 h-7 text-purple-300 group-hover:animate-bounce-icon transition-transform"></i>
                    Entrenamientos
                </h2>
                @if ($entrenamientos->isEmpty())
                    <p class="text-white opacity-80 mb-6 text-sm animate-pulse">No tienes entrenamientos asignados.</p>
                @else
                    <div
                        class="transition-all duration-500 ease-in-out max-h-0 overflow-hidden opacity-0 group-hover:max-h-96 group-hover:opacity-100 mt-4">
                        @foreach ($entrenamientos as $entrenamiento)
                            <div class="border-b border-purple-600 pb-3 mb-3 last:border-b-0">
                                <div class="text-white font-semibold text-lg">{{ $entrenamiento->nombre }}</div>
                                <div class="text-sm text-purple-100 opacity-90">{{ $entrenamiento->descripcion }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-purple-100 mt-4 text-xs opacity-90 group-hover:hidden animate-fade-in-up">Pasa el
                        ratón para ver tus entrenamientos.</p>
                @endif
            </div>

            <div
                class="bg-gradient-to-br from-pink-900 to-pink-700 p-8 rounded-3xl shadow-xl border border-pink-800 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group">
                <h2 class="text-2xl font-bold text-pink-200 mb-4 flex items-center gap-3">
                    <i data-feather="dollar-sign"
                        class="w-7 h-7 text-pink-300 group-hover:rotate-3 transition-transform"></i> Suscripciones
                </h2>
                @if ($suscripciones->isEmpty())
                    <p class="text-white opacity-80 mb-6 text-sm animate-pulse">Aún no tienes suscripciones activas.
                    </p>
                @else
                    <div
                        class="transition-all duration-500 ease-in-out max-h-0 overflow-hidden opacity-0 group-hover:max-h-96 group-hover:opacity-100 mt-4">
                        @foreach ($suscripciones as $suscripcion)
                            @if ($suscripcion->clase)
                                <div class="border-b border-pink-600 pb-3 mb-3 last:border-b-0">
                                    <div class="text-white font-semibold text-lg">{{ $suscripcion->clase->nombre }}
                                    </div>
                                    <div class="text-sm text-pink-100 opacity-90">
                                        Suscrito el {{ $suscripcion->created_at?->format('d/m/Y') ?? 'Sin fecha' }}
                                    </div>
                                </div>
                            @else
                                {{-- ESTE ES EL NUEVO CAMBIO para una visibilidad aún mayor --}}
                                <div
                                    class="text-sm **text-white** **bg-red-700** p-3 rounded mb-3 border border-red-500 font-bold flex items-center gap-2">
                                    <span class="text-lg">❌</span> Clase eliminada de una suscripción anterior.
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <p class="text-pink-100 mt-4 text-xs opacity-90 group-hover:hidden animate-fade-in-up">Pasa el
                        ratón
                        para ver tus suscripciones.</p>
                @endif
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mt-8">
            <div class="lg:col-span-4 flex flex-col space-y-8">
                <div class="bg-gray-800 p-8 rounded-3xl shadow-xl border border-gray-700">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-blue-400 flex items-center gap-3">
                            <i data-feather="bell" class="w-7 h-7 text-blue-500"></i> Notificaciones
                        </h2>
                        @if ($notificaciones->whereNull('read_at')->count() > 0)
                            <form action="{{ route('perfil.notificaciones.marcarTodasLeidas') }}" method="POST">
                                {{-- RUTA CORRECTA --}}
                                @csrf
                                <button type="submit"
                                    class="text-sm bg-blue-600 text-white px-4 py-2 rounded-full font-semibold hover:bg-blue-700 transition-colors duration-200 shadow-md">
                                    Marcar todas
                                </button>
                            </form>
                        @endif
                    </div>

                    @if ($notificaciones->isEmpty())
                        <p class="text-gray-400 text-center py-4">No tienes notificaciones recientes.</p>
                    @elseif ($notificaciones->whereNull('read_at')->count() === 0)
                        <div
                            class="text-green-400 bg-green-900 bg-opacity-30 p-5 rounded-lg flex items-center space-x-3 border border-green-700 animate-fade-in">
                            <i data-feather="check-circle" class="w-6 h-6 flex-shrink-0"></i>
                            <p class="font-medium">No tienes notificaciones pendientes.</p>
                        </div>
                    @else
                        <ul class="space-y-4">
                            @foreach ($notificaciones as $notificacion)
                                <li
                                    class="flex items-start justify-between gap-4 p-5 rounded-xl border {{ !$notificacion->read_at ? 'bg-blue-900 bg-opacity-30 border-blue-700' : 'bg-gray-700 border-gray-600' }} transition-all duration-300 hover:shadow-lg">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <i data-feather="mail"
                                                class="w-6 h-6 {{ !$notificacion->read_at ? 'text-blue-500' : 'text-gray-400' }}"></i>
                                            <span
                                                class="font-semibold text-white text-lg">{{ $notificacion->data['mensaje'] ?? 'Sin mensaje' }}</span>
                                        </div>
                                        <p class="text-sm text-gray-400 mt-1">
                                            {{ $notificacion->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div>
                                        @if (!$notificacion->read_at)
                                            <form
                                                action="{{ route('perfil.notificaciones.marcarLeida', $notificacion->id) }}"
                                                method="POST"> {{-- RUTA CORRECTA --}}
                                                @csrf
                                                <button type="submit"
                                                    class="text-sm text-blue-400 hover:text-blue-600 hover:underline font-medium transition-colors duration-200">Marcar
                                                    leída</button>
                                            </form>
                                        @else
                                            <span
                                                class="inline-block text-xs bg-gray-500 text-white px-3 py-1 rounded-full font-medium">Leída</span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div>
                    <a href="{{ route('tienda.index') }}" class="block group"> {{-- RUTA CORRECTA --}}
                        <div
                            class="bg-gray-800 rounded-3xl shadow-xl border border-gray-700 hover:shadow-2xl hover:bg-red-800 transition-all duration-300 ease-in-out transform hover:-translate-y-2 p-8 cursor-pointer text-center">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-24 w-24 text-red-500 mb-4 group-hover:text-white transition-colors duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <h1
                                    class="text-4xl font-bold text-red-500 group-hover:text-white transition-colors duration-200">
                                    Tienda</h1>
                                <p
                                    class="text-lg text-gray-400 mt-2 group-hover:text-gray-200 transition-colors duration-200">
                                    Explora nuestros productos de fitness</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-8">
                @if ($datosCompletos)
                    <div class="bg-gray-800 p-8 rounded-3xl shadow-xl border border-gray-700 h-full flex flex-col">
                        <h2 class="text-2xl font-bold text-red-400 mb-6 flex items-center gap-3">
                            <i data-feather="calendar" class="w-7 h-7 text-red-500"></i> Calendario de Clases
                        </h2>
                        <div id="calendar"
                            class="bg-gray-900 rounded-xl p-6 text-gray-200 shadow-inner border border-gray-700 flex-grow">
                            <p class="text-gray-500 text-center py-12">Cargando calendario...</p>
                            {{-- Placeholder mientras FullCalendar carga --}}
                        </div>
                    </div>
                @else
                    <div
                        class="bg-red-900 bg-opacity-30 p-8 rounded-3xl shadow-xl border border-red-700 flex items-center justify-center h-full text-center">
                        <p class="text-red-400 text-xl font-semibold leading-relaxed">
                            Completa tu perfil para acceder al calendario de clases y mucho más.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    {{-- Script para el slider (ajustado para manejo de tarjetas) --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sliderContainer = document.getElementById('sliderContainer');
                const prevButton = document.getElementById('prevSlide');
                const nextButton = document.getElementById('nextSlide');
                let currentIndex = 0;
                const slides = Array.from(sliderContainer.children);
                const totalSlides = slides.length;

                if (totalSlides === 0) {
                    prevButton.style.display = 'none';
                    nextButton.style.display = 'none';
                    return;
                }

                function getVisibleSlidesCount() {
                    const sliderWrapperWidth = sliderContainer.parentElement.clientWidth;
                    if (slides.length === 0) return 1;
                    const firstSlideWidth = slides[0].offsetWidth;
                    if (firstSlideWidth === 0) return 1;
                    return Math.floor(sliderWrapperWidth / firstSlideWidth);
                }

                function updateSlider() {
                    const visibleSlidesCount = getVisibleSlidesCount();
                    const slideWidth = slides[0].offsetWidth;

                    const maxIndex = totalSlides - visibleSlidesCount;
                    if (currentIndex > maxIndex) {
                        currentIndex = Math.max(0, maxIndex);
                    }
                    if (currentIndex < 0) {
                        currentIndex = 0;
                    }

                    sliderContainer.style.transform = `translateX(-${currentIndex * slideWidth}px)`;

                    prevButton.disabled = currentIndex === 0;
                    nextButton.disabled = currentIndex >= maxIndex;

                    prevButton.style.opacity = currentIndex === 0 ? '0.5' : '1';
                    nextButton.style.opacity = currentIndex >= maxIndex ? '0.5' : '1';

                    prevButton.style.cursor = currentIndex === 0 ? 'not-allowed' : 'pointer';
                    nextButton.style.cursor = currentIndex >= maxIndex ? 'not-allowed' : 'pointer';
                }

                nextButton.addEventListener('click', () => {
                    const visibleSlidesCount = getVisibleSlidesCount();
                    const maxIndex = totalSlides - visibleSlidesCount;
                    if (currentIndex < maxIndex) {
                        currentIndex++;
                    }
                    updateSlider();
                });

                prevButton.addEventListener('click', () => {
                    if (currentIndex > 0) {
                        currentIndex--;
                    }
                    updateSlider();
                });

                window.addEventListener('resize', () => {
                    currentIndex = 0;
                    updateSlider();
                });

                updateSlider();
            });
        </script>
        @vite('resources/js/scripts/calendario.js')
        <script>
            window.eventosClases = @json($eventos ?? []);
        </script>
    @endpush
</x-app-layout>
