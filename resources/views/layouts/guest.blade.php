<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sistem Keluhan') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-indigo-50 to-white">
            
            <div class="text-center mb-6" data-aos="fade-down">
                <a href="/" class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg mb-3 transform rotate-3 hover:rotate-0 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Sistem Keluhan Kampus</h1>
                    <p class="text-sm text-gray-500">Silakan login untuk melanjutkan</p>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-xl shadow-gray-200/50 overflow-hidden sm:rounded-2xl border border-gray-100" data-aos="fade-up" data-aos-delay="100">
                {{ $slot }}
            </div>

            <div class="mt-6 text-center text-xs text-gray-400" data-aos="fade-in" data-aos-delay="200">
                &copy; {{ date('Y') }} Universitas Teknologi. All rights reserved.
            </div>
        </div>

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({ duration: 800, once: true });
        </script>
    </body>
</html>