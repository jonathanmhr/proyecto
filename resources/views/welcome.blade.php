<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PowerCore - Gimnasio</title>
    <!-- Incluyendo Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJx3p3hJxRz3Z2Yxj/Xm7v4bM9u0Yfuv3/tnx4Z3zOygBz1Wptua3qfcmz5F" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

    <!-- Main Container -->
    <div class="d-flex justify-content-center align-items-center min-vh-100 bg-gradient text-white">
        <!-- Card with content -->
        <div class="card text-center p-4" style="max-width: 600px; width: 100%; background: linear-gradient(45deg, rgba(129, 59, 255, 0.8), rgba(53, 43, 255, 0.8));">
            <div class="card-body">
                <h1 class="display-4 font-weight-bold mb-4">
                    Bienvenido a <span class="text-warning">PowerCore</span>
                </h1>
                <p class="lead mb-4">
                    El gimnasio que te lleva al siguiente nivel. Potencia tu entrenamiento con nosotros.
                </p>

                <!-- Button Group -->
                <div class="d-flex justify-content-center gap-3">
                    <!-- Log in Button -->
                    <a href="{{ route('login') }}" class="btn btn-warning btn-lg text-dark fw-bold px-5 py-3">
                        Iniciar sesión
                    </a>

                    <!-- Register Button -->
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg text-white fw-bold px-5 py-3">
                        Únete hoy
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5 text-center">
        <p>&copy; {{ date('Y') }} PowerCore. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0hpwXqIARF2k8v2tLAL0X9BtkjNhA3kzHF91yRj6hz5uNC1v" crossorigin="anonymous"></script>
</body>
</html>
