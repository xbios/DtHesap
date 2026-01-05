<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'DtHesap ERP' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Page Content -->
    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <x-alert type="success" class="mb-4">
                    {{ session('success') }}
                </x-alert>
            @endif

            @if(session('error'))
                <x-alert type="error" class="mb-4">
                    {{ session('error') }}
                </x-alert>
            @endif

            <!-- Page Content -->
            @yield('content')
            @isset($slot)
                {{ $slot }}
            @endisset
        </div>
    </main>
</body>
</html>