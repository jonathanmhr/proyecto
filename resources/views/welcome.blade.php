<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PowerCore - Tu gimnasio definitivo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans">

<!-- Header -->
<header class="bg-gray-950 fixed w-full z-10 shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-red-600">PowerCore</h1>
        <nav class="space-x-6">
            <a href="#inicio" class="hover:text-red-500 transition">Inicio</a>
            <a href="#clases" class="hover:text-red-500 transition">Clases</a>
            <a href="#entrenadores" class="hover:text-red-500 transition">Entrenadores</a>
            <a href="#contacto" class="hover:text-red-500 transition">Contacto</a>
        </nav>
    </div>
</header>

<!-- Hero -->
<section id="inicio" class="h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1583454110550-4f66f6b0d79e');">
    <div class="bg-black bg-opacity-60 p-10 rounded-xl text-center">
        <h2 class="text-4xl md:text-5xl font-extrabold mb-4">Transforma tu cuerpo, transforma tu vida</h2>
        <p class="text-lg mb-6">Únete a PowerCore y alcanza tus metas con los mejores entrenadores y clases personalizadas.</p>
        <a href="#clases" class="bg-red-600 hover:bg-red-700 text-white py-3 px-6 rounded-xl text-lg transition">Descubre nuestras clases</a>
    </div>
</section>

<!-- Beneficios -->
<section class="py-20 bg-gray-800 text-center">
    <h3 class="text-3xl font-bold mb-10">¿Por qué elegir PowerCore?</h3>
    <div class="grid md:grid-cols-3 gap-10 max-w-6xl mx-auto px-4">
        <div>
            <h4 class="text-xl font-semibold mb-2">Entrenadores Expertos</h4>
            <p>Contamos con profesionales certificados que te guiarán en todo momento.</p>
        </div>
        <div>
            <h4 class="text-xl font-semibold mb-2">Equipamiento de Última Generación</h4>
            <p>Instalaciones modernas y máquinas de alta gama para entrenar con seguridad.</p>
        </div>
        <div>
            <h4 class="text-xl font-semibold mb-2">Planes Personalizados</h4>
            <p>Adaptamos tu entrenamiento y dieta según tus objetivos y necesidades.</p>
        </div>
    </div>
</section>

<!-- Clases -->
<section id="clases" class="py-20">
    <div class="max-w-6xl mx-auto px-4">
        <h3 class="text-3xl font-bold text-center mb-10">Clases destacadas</h3>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
                <h4 class="text-xl font-semibold mb-2">HIIT</h4>
                <p>Entrenamientos intensos para quemar grasa y mejorar tu resistencia.</p>
            </div>
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
                <h4 class="text-xl font-semibold mb-2">Funcional</h4>
                <p>Mejora tu movilidad y fuerza con ejercicios prácticos y variados.</p>
            </div>
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
                <h4 class="text-xl font-semibold mb-2">Yoga</h4>
                <p>Conecta cuerpo y mente mientras trabajas tu flexibilidad y equilibrio.</p>
            </div>
        </div>
    </div>
</section>

<!-- Entrenadores -->
<section id="entrenadores" class="py-20 bg-gray-800">
    <div class="max-w-6xl mx-auto px-4">
        <h3 class="text-3xl font-bold text-center mb-10">Nuestros entrenadores</h3>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-gray-700 p-6 rounded-xl text-center">
                <img src="https://via.placeholder.com/100" class="rounded-full mx-auto mb-4" alt="Entrenador 1">
                <h4 class="text-xl font-semibold">Carlos Fit</h4>
                <p>Especialista en fuerza y musculación.</p>
            </div>
            <div class="bg-gray-700 p-6 rounded-xl text-center">
                <img src="https://via.placeholder.com/100" class="rounded-full mx-auto mb-4" alt="Entrenador 2">
                <h4 class="text-xl font-semibold">Lucía Zen</h4>
                <p>Instructora de yoga y bienestar.</p>
            </div>
            <div class="bg-gray-700 p-6 rounded-xl text-center">
                <img src="https://via.placeholder.com/100" class="rounded-full mx-auto mb-4" alt="Entrenador 3">
                <h4 class="text-xl font-semibold">Marco Power</h4>
                <p>Entrenador funcional y HIIT.</p>
            </div>
        </div>
    </div>
</section>

<!-- Contacto -->
<section id="contacto" class="py-20 text-center">
    <h3 class="text-3xl font-bold mb-6">¿Listo para empezar?</h3>
    <p class="mb-6">Contáctanos o visítanos en nuestras instalaciones.</p>
    <a href="mailto:info@powercore.com" class="bg-red-600 hover:bg-red-700 text-white py-3 px-6 rounded-xl text-lg transition">Escríbenos</a>
</section>

<!-- Footer -->
<footer class="bg-gray-950 py-6 text-center text-gray-400">
    <p>&copy; 2025 PowerCore. Todos los derechos reservados.</p>
</footer>

</body>
</html>
