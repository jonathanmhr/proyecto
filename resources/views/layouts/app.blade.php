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
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased">
    <x-banner />

    <!-- Sidebar Layout -->
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-white border-r transition-all duration-300 overflow-hidden relative">
            <!-- Toggle Button -->
            <button @click="sidebarOpen = !sidebarOpen" class="absolute top-4 right-2 z-10 text-gray-600 hover:text-gray-900">
                <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Sidebar Content -->
            <div class="flex flex-col h-full pt-16">
                <nav class="flex-1 space-y-2 px-4">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 text-gray-700 hover:bg-gray-200 p-2 rounded-md transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span x-show="sidebarOpen" class="text-sm">Dashboard</span>
                    </a>
                    <!-- Agrega más enlaces aquí -->
                </nav>

                <!-- Footer -->
                <div class="p-4 border-t">
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <button class="flex items-center space-x-3 text-sm text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M17 16l4-4m0 0l-4-4m4 4H7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span x-show="sidebarOpen">Cerrar sesión</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main :class="sidebarOpen ? 'ml-64' : 'ml-20'" class="transition-all duration-300 p-6 w-full">
            {{ $slot }}
        </main>
    </div>

    @stack('modals')
    @livewireScripts
</body>

</html>
