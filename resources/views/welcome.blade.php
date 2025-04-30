<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitCore - Tu gimnasio definitivo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans">

    <!-- Header -->
    <header class="bg-gray-950 fixed w-full z-10 shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-3xl font-extrabold text-red-500">FitCore</h1>
            <nav class="space-x-6 text-lg">
                <a href="#inicio" class="hover:text-red-400 transition">Inicio</a>
                <a href="#clases" class="hover:text-red-400 transition">Clases</a>
                <a href="#entrenadores" class="hover:text-red-400 transition">Entrenadores</a>
                <a href="#contacto" class="hover:text-red-400 transition">Contacto</a>
            </nav>
            <!-- Login -->
            <div class="flex items-center space-x-4">
                <a href="#" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg text-sm transition">Iniciar sesión</a>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section id="inicio" class="h-screen flex items-center justify-center bg-cover bg-center relative" style="background-image: url('https://images.unsplash.com/photo-1583454110550-4f66f6b0d79e');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative text-center p-10">
            <h2 class="text-5xl font-extrabold mb-4">Supera tus límites, alcanza tus metas</h2>
            <p class="text-xl mb-6">Únete a FitCore y transforma tu cuerpo con los mejores entrenadores y clases.</p>
            <a href="#clases" class="bg-red-500 hover:bg-red-600 text-white py-3 px-8 rounded-full text-lg transition">Descubre más</a>
        </div>
    </section>

    <!-- Clases -->
    <section id="clases" class="py-20 text-center">
        <h3 class="text-4xl font-bold mb-10">Nuestras Clases</h3>
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <div class="bg-gray-800 p-8 rounded-xl shadow-lg">
                <h4 class="text-2xl font-semibold mb-2">HIIT Intensivo</h4>
                <p>Quema grasa y mejora resistencia con entrenamientos de alta intensidad.</p>
            </div>
            <div class="bg-gray-800 p-8 rounded-xl shadow-lg">
                <h4 class="text-2xl font-semibold mb-2">Funcional</h4>
                <p>Mejora tu movilidad y fuerza con ejercicios adaptativos.</p>
            </div>
            <div class="bg-gray-800 p-8 rounded-xl shadow-lg">
                <h4 class="text-2xl font-semibold mb-2">Yoga & Relajación</h4>
                <p>Conéctate contigo mismo y mejora tu flexibilidad.</p>
            </div>
        </div>
    </section>

    <!-- Contacto -->
    <section id="contacto" class="py-20 text-center bg-gray-800">
        <h3 class="text-4xl font-bold mb-6">¿Listo para comenzar?</h3>
        <p class="text-xl mb-6">Contáctanos y empieza tu transformación hoy.</p>
        <a href="mailto:info@fitcore.com" class="bg-red-500 hover:bg-red-600 text-white py-3 px-8 rounded-full text-lg transition">Contáctanos</a>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-950 py-6 text-center text-gray-400">
        <p>&copy; 2025 FitCore. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
