<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida a PowerCore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <nav class="bg-black text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-xl font-bold">PowerCore</a>
            <div class="space-x-4">
                <a href="/" class="hover:text-yellow-400">Inicio</a>
                <a href="#features" class="hover:text-yellow-400">Servicios</a>
                <a href="#contact" class="hover:text-yellow-400">Contacto</a>
                <a href="{{ route('login') }}" class="hover:text-yellow-400">Iniciar sesión</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative bg-cover bg-center h-screen" style="background-image: url('/images/hero-bg.jpg');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative z-10 text-center text-white py-40">
            <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-4">Bienvenido a PowerCore</h1>
            <p class="text-xl mb-8">Transforma tu cuerpo y tu mente con nuestros entrenamientos personalizados</p>
            <a href="#features" class="bg-yellow-400 text-black px-6 py-3 rounded-lg text-lg hover:bg-yellow-500 transition">Descubre nuestros servicios</a>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-200">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold mb-8">Nuestros Servicios</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                <!-- Servicio 1 -->
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <h3 class="text-2xl font-semibold mb-4">Entrenamientos Personalizados</h3>
                    <p>Sesiones adaptadas a tus objetivos personales y nivel físico.</p>
                </div>
                <!-- Servicio 2 -->
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <h3 class="text-2xl font-semibold mb-4">Clases Grupales</h3>
                    <p>Disfruta de nuestras clases grupales energizantes y motivadoras.</p>
                </div>
                <!-- Servicio 3 -->
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <h3 class="text-2xl font-semibold mb-4">Plan de Nutrición</h3>
                    <p>Recibe planes de nutrición personalizados para complementar tu entrenamiento.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-black text-white text-center py-8">
        <p>&copy; 2025 PowerCore Gym. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
