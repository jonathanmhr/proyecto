<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Clases Disponibles') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-900 text-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($clases as $clase) {{-- Asegúrate de que tu controlador pasa una variable llamada $clases --}}
                    <div class="bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1 overflow-hidden border border-gray-700">
                        <div class="aspect-w-16 aspect-h-9 flex items-center justify-center bg-gray-700 h-48 rounded-t-xl overflow-hidden">
                            @if($clase->imagen && file_exists(public_path('storage/' . $clase->imagen)))
                                <img src="{{ asset('storage/' . $clase->imagen) }}" alt="{{ $clase->nombre }}" class="object-cover w-full h-full">
                            @else
                                @php
                                    $iniciales = collect(explode(' ', $clase->nombre))->map(fn($p) => strtoupper(substr($p, 0, 1)))->join('');
                                @endphp
                                <div class="w-24 h-24 bg-red-600 text-white rounded-full flex items-center justify-center text-2xl font-bold">
                                    {{ $iniciales }}
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="text-xl font-bold text-gray-100 mb-1">{{ $clase->nombre }}</h3>
                            <p class="text-sm text-gray-400 mb-3 line-clamp-2">{{ Str::limit($clase->descripcion, 80) }}</p>

                            {{-- **Lógica para el botón de unirse a la clase** --}}
                            {{-- IMPORTANTE: Asegúrate de que el controlador adjunta el estado de inscripción a cada objeto $clase,
                                por ejemplo, como $clase->user_enrollment_status. --}}

                            @if(isset($clase->user_enrollment_status) && $clase->user_enrollment_status === 'pending')
                                <button disabled
                                    class="w-full bg-yellow-600 text-white py-2 rounded-lg cursor-not-allowed flex items-center justify-center opacity-75">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Solicitud Pendiente
                                </button>
                                <p class="text-sm text-yellow-300 mt-2 text-center">Tu solicitud ha sido enviada y está pendiente de aprobación.</p>
                            @elseif(isset($clase->user_enrollment_status) && $clase->user_enrollment_status === 'accepted')
                                <button disabled
                                    class="w-full bg-green-600 text-white py-2 rounded-lg cursor-not-allowed flex items-center justify-center opacity-75">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    ¡Inscrito!
                                </button>
                                <p class="text-sm text-green-300 mt-2 text-center">¡Ya eres parte de esta clase!</p>
                            @elseif(isset($clase->user_enrollment_status) && $clase->user_enrollment_status === 'rejected')
                                <form action="{{ route('clases.unirse', $clase->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-200 ease-in-out flex items-center justify-center">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 14c-1.478 0-2.91-0.292-4.225-0.843a6.002 6.002 0 00-1.23-2.055 6.002 6.002 0 011.23-2.055C9.09 9.292 10.522 9 12 9s2.91 0.292 4.225 0.843a6.002 6.002 0 011.23 2.055 6.002 6.002 0 00-1.23 2.055C14.91 14.708 13.478 15 12 15z" />
                                        </svg>
                                        Re-solicitar Acceso
                                    </button>
                                </form>
                                <p class="text-sm text-red-300 mt-2 text-center">Tu solicitud anterior fue rechazada. Puedes volver a intentarlo.</p>
                            @else {{-- No hay solicitud o estado desconocido (disponible para unirse) --}}
                                <form action="{{ route('clases.unirse', $clase->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition duration-200 ease-in-out flex items-center justify-center">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Unirse a la Clase
                                    </button>
                                </form>
                            @endif
                            {{-- **Fin de la lógica para el botón de unirse a la clase** --}}

                            {{-- El botón "Ver Detalles" si aún lo necesitas para las clases --}}
                            <button onclick="mostrarDetalle({{ $clase->id }})"
                                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200 ease-in-out flex items-center justify-center mt-3">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Ver Detalles de Clase
                            </button>

                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-400 text-lg py-10">
                        <p>No se encontraron clases disponibles.</p>
                        <p class="mt-2">Intenta con otros términos o explora nuestras categorías.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $clases->links() }} {{-- Asegúrate de que $clases sea una colección paginada si usas links() --}}
            </div>
        </div>
    </div>

    {{-- Tu modal de detalles existente, adaptado para "clases" si lo necesitas --}}
    <div id="modal-detalle" class="fixed inset-0 bg-black bg-opacity-75 flex justify-center items-center z-50 transition-opacity duration-300 ease-out opacity-0 pointer-events-none hidden">
        <div class="bg-gray-800 rounded-xl shadow-2xl max-w-lg w-full p-8 relative transform scale-95 transition-transform duration-300 ease-out border border-gray-700">
            <button onclick="cerrarModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-100 text-3xl font-light leading-none">&times;</button>
            <div id="contenido-modal">
                <div class="flex justify-center items-center h-48">
                    <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-700 h-12 w-12 mb-4"></div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .loader {
            border-top-color: #E72E4E;
            animation: spinner 1.5s linear infinite;
        }

        @keyframes spinner {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <script>
        // Tu función existente mostrarDetalle() y cerrarModal()
        // Necesitarás adaptar esta función para que cargue los detalles de una CLASE, no de un PRODUCTO
        // y para que la ruta de fetch sea algo como `/clases/clase-json/${id}`
        function mostrarDetalle(id) {
            const modal = document.getElementById('modal-detalle');
            const contenidoModal = document.getElementById('contenido-modal');

            contenidoModal.innerHTML = `
                <div class="flex justify-center items-center h-48">
                    <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-700 h-12 w-12 mb-4"></div>
                </div>
            `;

            modal.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100');
            modal.querySelector('.transform').classList.replace('scale-95', 'scale-100');

            // Cambia esta ruta para que apunte a tu endpoint de detalles de CLASE
            fetch(`/clases/clase-json/${id}`) // <-- Asegúrate de que esta ruta exista en tus web.php
                .then(response => {
                    if (!response.ok) throw new Error('No se encontró la clase.');
                    return response.json();
                })
                .then(clase => { // Cambiado 'producto' a 'clase'
                    contenidoModal.innerHTML = `
                        <div class="flex flex-col md:flex-row items-center gap-6 text-gray-100">
                            <div class="flex-shrink-0">
                                ${clase.imagen ?
                                    `<img src="/storage/${clase.imagen}" alt="${clase.nombre}" class="object-cover w-48 h-48 rounded-lg shadow-md border border-gray-700">`
                                    :
                                    `<div class="w-48 h-48 bg-red-600 text-white rounded-lg flex items-center justify-center text-4xl font-bold shadow-md">
                                        ${clase.nombre.split(' ').map(p => p.charAt(0).toUpperCase()).join('')}
                                    </div>`}
                            </div>
                            <div class="flex-grow text-center md:text-left">
                                <h2 class="text-3xl font-bold mb-2">${clase.nombre}</h2>
                                <p class="text-gray-400 mb-4 text-sm">${clase.descripcion}</p>
                                {{-- Si las clases tienen precio, puedes descomentar esto: --}}
                                {{-- <p class="text-red-500 font-extrabold text-4xl mb-4">€${parseFloat(clase.precio).toFixed(2).replace('.', ',')}</p> --}}

                                {{-- Aquí iría cualquier acción específica del modal para la clase (ej. "Inscribirse desde el modal") --}}
                                <p class="text-gray-300">Más detalles sobre la clase aquí...</p>
                            </div>
                        </div>
                    `;
                })
                .catch(error => {
                    contenidoModal.innerHTML = `
                        <div class="text-center py-10">
                            <p class="text-red-400 font-semibold mb-2">Error al cargar la clase.</p>
                            <p class="text-gray-400 text-sm">${error.message}</p>
                        </div>
                    `;
                });
        }

        function cerrarModal() {
            const modal = document.getElementById('modal-detalle');
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            modal.querySelector('.transform').classList.replace('scale-100', 'scale-95');
            setTimeout(() => {
                modal.classList.add('hidden', 'pointer-events-none');
                document.getElementById('contenido-modal').innerHTML = '';
            }, 300);
        }

        document.getElementById('modal-detalle').addEventListener('click', function (e) {
            if (e.target === this) cerrarModal();
        });
    </script>
</x-app-layout>