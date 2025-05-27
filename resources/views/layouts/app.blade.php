<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles y Scripts Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-white">
        <!-- Sidebar -->
        <x-sidebar />

        <!-- Contenido principal -->
        <main :class="sidebarOpen ? 'ml-64' : 'ml-20'" class="transition-all duration-300 w-full p-6">
            {{ $slot }}
        </main>
    </div>

    @stack('modals')
    @stack('scripts')
    @livewireScripts

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        document.addEventListener('alpine:initialized', () => feather.replace());
        document.addEventListener('alpine:reinitialized', () => feather.replace());
    </script>

    <!-- ApexCharts desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Tu script personalizado para ApexCharts -->
    <script src="{{ asset('js/app/components/apexcharts.js') }}"></script>
</body>

</html>
