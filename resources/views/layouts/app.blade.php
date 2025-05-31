<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Power-Core') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/feather-icons"></script>
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gray-900 m-0 p-0">
    <x-banner />

    <div class="min-h-screen bg-gray-900">

        <x-sidebar />

        <main class="min-h-screen p-6 transition-all duration-300 pl-24 lg:pl-72">
            {{ $slot }}
        </main>
    </div>

    @stack('modals')
    @stack('scripts')
    @livewireScripts
</body>

</html>
