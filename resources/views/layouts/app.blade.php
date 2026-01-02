<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-mesh relative">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute top-0 left-0 w-96 h-96 bg-primary-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse-slow">
            </div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-secondary-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse-slow"
                style="animation-delay: 1s;"></div>
            <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-accent-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse-slow"
                style="animation-delay: 2s;"></div>
        </div>

        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="shadow-sm relative z-10">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="relative z-10">
            {{ $slot }}
        </main>
    </div>
</body>

</html>