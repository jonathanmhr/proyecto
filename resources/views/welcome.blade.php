<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PowerCore - Tu gimnasio definitivo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white font-sans">

    <!-- Header -->
    <header class="bg-gray-950 fixed w-full z-10 shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-3xl font-extrabold "><span class="text-white-500">Power</span><span class="text-red-500">Core</span></h1>
            <nav class="space-x-6 text-lg">
                <a href="#inicio" class="hover:text-red-400 transition">Inicio</a>
                <a href="#clases" class="hover:text-red-400 transition">Clases</a>
                <a href="#entrenadores" class="hover:text-red-400 transition">Entrenadores</a>
                <a href="#contacto" class="hover:text-red-400 transition">Contacto</a>
            </nav>
            <!-- Login -->
            <div class="flex items-center space-x-4">
                <a href="/login"
                    class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg text-sm transition">Iniciar
                    sesión</a>
            </div>
        </div>
    </header>
    <section id="inicio" class="h-screen flex items-center justify-center bg-cover bg-center relative"
        style="background-image: url('https://images.unsplash.com/photo-1583454110550-4f66f6b0d79e');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative text-center p-10 hover:text-red-500 transition-all duration-300">
            <h2 class="text-5xl font-extrabold mb-4">Supera tus límites, alcanza tus metas</h2>
            <p class="text-xl mb-6">Únete a PowerCore y transforma tu cuerpo con los mejores entrenadores y clases.</p>
            <a href="#clases"
                class="bg-red-500 hover:bg-red-600 text-white py-3 px-8 rounded-full text-lg transition">Descubre
                más</a>
        </div>
    </section>
    <div class="group transition-all duration-2000">
        <section id="clases" class="py-20 text-center">
            <h3 class="text-4xl font-bold mb-10">Nuestras Clases</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 group-hover:grid-cols-1 gap-8 max-w-6xl mx-auto transition-all duration-500">
                <div class="relative bg-gray-800 rounded-xl shadow-lg overflow-hidden group-hover:scale-105 transition-transform duration-500 group">
                    <div class="flex items-center p-8 transition-all duration-500 group-hover:pl-4 text-left">
                        <div class="w-full">
                            <h4 class="text-2xl font-semibold mb-2">HIIT Intensivo</h4>
                            <p>Quema grasa y mejora resistencia con entrenamientos de alta intensidad.</p>
                        </div>
                    </div>
                    <div class="absolute top-0 right-0 h-full w-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        <img src="resources\images\pesas.jpg" alt="HIIT" class="object-cover h-full w-full">
                    </div>
                </div>
                <div class="relative bg-gray-800 rounded-xl shadow-lg overflow-hidden group-hover:scale-105 transition-transform duration-500 group">
                    <div class="flex items-center p-8 transition-all duration-500 group-hover:pl-4 text-left">
                        <div class="w-full">
                            <h4 class="text-2xl font-semibold mb-2">Funcional</h4>
                            <p>Mejora tu movilidad y fuerza con ejercicios adaptativos.</p>
                        </div>
                    </div>
                    <div class="absolute top-0 right-0 h-full w-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        <img src="" alt="Funcional" class="object-cover h-full w-full">
                    </div>
                </div>
                <div class="relative bg-gray-800 rounded-xl shadow-lg overflow-hidden group-hover:scale-105 transition-transform duration-500 group">
                    <div class="flex items-center p-8 transition-all duration-500 group-hover:pl-4 text-left">
                        <div class="w-full">
                            <h4 class="text-2xl font-semibold mb-2">Yoga & Relajación</h4>
                            <p>Conéctate contigo mismo y mejora tu flexibilidad.</p>
                        </div>
                    </div>
                <div class="absolute top-0 right-0 h-full w-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <img src="" alt="Yoga" class="object-cover h-full w-full">
                </div>
            </div>
      
        </section>
    </div>

    <section id="beneficios" class="py-20 bg-gray-800 text-center transition-all duration-300">
        <h3 class="text-4xl font-bold mb-10 text-white">¿Por qué elegir PowerCore?</h3>
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="bg-gray-700 text-white p-6 rounded-xl shadow-xl hover:shadow-2xl hover:text-red-500 hover:scale-105 transition-all duration-300 transform">
                <h4 class="text-2xl font-semibold mb-2">Entrenadores Certificados</h4>
                <p>Expertos en fitness que te guiarán en todo momento.</p>
            </div>
            <div class="bg-gray-700 text-white p-6 rounded-xl shadow-xl hover:shadow-2xl hover:text-red-500 hover:scale-105 transition-all duration-300 transform">
                <h4 class="text-2xl font-semibold mb-2">Equipamiento de Última Generación</h4>
                <p>Instalaciones modernas y máquinas avanzadas.</p>
            </div>
            <div class="bg-gray-700 text-white p-6 rounded-xl shadow-xl hover:shadow-2xl hover:text-red-500 hover:scale-105 transition-all duration-300 transform">
                <h4 class="text-2xl font-semibold mb-2">Planes Personalizados</h4>
                <p>Adaptamos el entrenamiento según tus necesidades.</p>
            </div>
        </div>
    </section>

    <section id="testimonios" class="py-20 text-center">
        <h3 class="text-4xl font-bold mb-10">Lo que dicen nuestros clientes</h3>
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8">
            <div class="bg-gray-800 p-6 rounded-xl">
                <p class="italic">"PowerCore cambió mi vida. Los entrenadores son increíbles y el ambiente es
                        motivador."</p>
                <h4 class="mt-4 font-semibold">- Laura G.</h4>
            </div>
            <div class="bg-gray-800 p-6 rounded-xl">
                <p class="italic">"Nunca había visto un gimnasio con equipos tan buenos y clases tan dinámicas. ¡Lo
                        recomiendo!"</p>
                <h4 class="mt-4 font-semibold">- Pedro R.</h4>
            </div>
        </div>
    </section>
    <section id="membresias" class="py-20 bg-gray-800 text-center">
        <h3 class="text-4xl font-bold mb-10">Elige tu plan de entrenamiento</h3>
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="bg-gray-700 p-6 rounded-xl shadow-lg hover:shadow-2xl hover:bg-red-500 transition-all duration-300">
                <h4 class="text-2xl font-semibold mb-2">Básico</h4>
                <p>Acceso al gimnasio y equipos esenciales.</p>
                    <p class="text-xl font-bold mt-4">€29/mes</p>
            </div>
            <div class="bg-gray-700 p-6 rounded-xl shadow-lg hover:shadow-2xl hover:bg-red-500 transition-all duration-300">
                <h4 class="text-2xl font-semibold mb-2">Premium</h4>
                <p>Clases grupales y asesoramiento personalizado.</p>
                    <p class="text-xl font-bold mt-4">€49/mes</p>
            </div>
            <div class="bg-gray-700 p-6 rounded-xl shadow-lg hover:shadow-2xl hover:bg-red-500 transition-all duration-300">
                <h4 class="text-2xl font-semibold mb-2">Elite</h4>
                <p>Acceso VIP, entrenadores privados y nutrición personalizada.</p>
                    <p class="text-xl font-bold mt-4">€79/mes</p>
            </div>
        </div>
    </section>
    <section id="contacto" class="py-20 text-center bg-gray-800">
        <div class="grid md:grid-cols-3 gap-2 max-w-6xl mx-auto">
            <div>

            </div>
            <div class="hover:scale-110 transition-transform duration-300">
                <h3 class="text-4xl font-bold mb-6">¿Listo para comenzar?</h3>
                <p class="text-xl mb-6">Contáctanos y empieza tu transformación hoy.</p>
                <a href="mailto:info@PowerCore.com"
                class="bg-red-500 hover:bg-red-600 text-white py-3 px-8 rounded-full text-lg transition">Contáctanos</a>
            </div>
            <div>

            </div>
        </div>
    </section>
    <footer class="bg-gray-950 py-6 text-center text-gray-400">
        <p>&copy; 2025 PowerCore. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
