<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Fesbok</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="{{ asset('storage/Black White Elegant Personal Monogram Logo (1).png') }}">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <livewire:welcome.navigation />
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center">
                    <img class="w-40 h-40 fill-current" src="{{ asset('storage/Black White Elegant Personal Monogram Logo (1).png') }}" alt="logo">
                </div>

                <div class="flex-wrap justify-center mt-6 px-0 sm:items-center sm:justify-between">
                    <div class="text-center text-sm sm:text-start">
                        <livewire:chirps.listChirp>
                    </div>
                </div>                
            </div>
        </div>
    </body>
</html>
