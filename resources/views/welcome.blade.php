<!-- resources/views/index.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <!-- Vincula Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Navbar -->
    <nav class="bg-blue-500 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-white text-2xl font-bold">Mi Proyecto</a>
            <ul class="flex space-x-6">
                <li><a href="/" class="text-white hover:text-gray-200">Inicio</a></li>
                <li><a href="/about" class="text-white hover:text-gray-200">Sobre nosotros</a></li>
                <li><a href="/contact" class="text-white hover:text-gray-200">Contacto</a></li>
                <li><a href="{{ route('login') }}" class="text-white hover:text-gray-200"> Iniciar sesión</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Bienvenido a Mi Proyecto</h1>
            <p class="text-lg text-gray-600 mb-6">Una aplicación web creada con Laravel y Tailwind CSS.</p>

            <a href="/more-info" class="bg-blue-500 text-white px-6 py-3 rounded-full text-lg hover:bg-blue-700 transition">Descubre más</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4">
        <p>&copy; 2025 Mi Proyecto - Todos los derechos reservados</p>
    </footer>

</body>
</html>
