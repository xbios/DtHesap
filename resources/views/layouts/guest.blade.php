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
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-mesh relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute top-20 left-10 w-72 h-72 bg-primary-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse-slow">
            </div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-secondary-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse-slow"
                style="animation-delay: 1s;"></div>
            <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-accent-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse-slow"
                style="animation-delay: 2s;"></div>
        </div>

        <!-- Logo -->
        <div class="animate-slide-up">
            <a href="/" class="block">
                <div
                    class="flex items-center justify-center w-16 h-16 bg-gradient-primary rounded-2xl shadow-glow mb-6 hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </a>
        </div>

        <!-- Content Card -->
        <div
            class="w-full sm:max-w-md mt-6 px-8 py-8 glass-strong rounded-3xl shadow-glass-lg backdrop-blur-xl animate-scale-in relative z-10">
            {{ $slot }}
        </div>

        <!-- Footer Text -->
        <div class="mt-6 text-center text-sm text-neutral-600 animate-fade-in">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>