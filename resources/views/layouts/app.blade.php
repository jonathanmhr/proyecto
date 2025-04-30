<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <x-sidebar />

        <!-- Contenido principal -->
        <main :class="sidebarOpen ? 'ml-64' : 'ml-20'" class="transition-all duration-300 w-full p-6">
            {{ $slot }}
        </main>
    </div>

    @stack('modals')
    @livewireScripts

    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('feather', {
                refresh: () => feather.replace()
            })
        })
    
        document.addEventListener('DOMContentLoaded', () => {
            feather.replace()
        })
    
        document.addEventListener('alpine:initialized', () => {
            feather.replace()
        })
    </script>
</body>


</html>
