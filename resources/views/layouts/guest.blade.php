<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Keluhan') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex">
        <!-- Left Side - Branding -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 relative overflow-hidden">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0">
                <div class="absolute top-20 left-20 w-64 h-64 bg-white/10 rounded-full mix-blend-overlay filter blur-xl animate-pulse"></div>
                <div class="absolute bottom-20 right-20 w-80 h-80 bg-white/10 rounded-full mix-blend-overlay filter blur-xl animate-pulse" style="animation-delay: 1s;"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-white/5 rounded-full"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-center px-12 xl:px-20">
                <div class="mb-8" data-aos="fade-right">
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-6 shadow-2xl">
                        <i class="fas fa-graduation-cap text-white text-3xl"></i>
                    </div>
                    <h1 class="text-4xl xl:text-5xl font-bold text-white mb-4 leading-tight">
                        Sistem Keluhan<br>Mahasiswa
                    </h1>
                    <p class="text-white/80 text-lg xl:text-xl max-w-md">
                        Platform digital untuk menyampaikan aspirasi dan keluhan secara mudah dan transparan.
                    </p>
                </div>

                <!-- Features -->
                <div class="space-y-4" data-aos="fade-right" data-aos-delay="200">
                    <div class="flex items-center gap-4 text-white/90">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <span>Proses cepat dan efisien</span>
                    </div>
                    <div class="flex items-center gap-4 text-white/90">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <i class="fas fa-bell"></i>
                        </div>
                        <span>Notifikasi WhatsApp otomatis</span>
                    </div>
                    <div class="flex items-center gap-4 text-white/90">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <span>Pantau progress secara real-time</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Decoration -->
            <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-black/20 to-transparent"></div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 sm:p-12 bg-gradient-to-br from-slate-50 via-white to-indigo-50">
            <!-- Mobile Logo (shown only on mobile) -->
            <div class="lg:hidden text-center mb-8" data-aos="fade-down">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Sistem Keluhan</h1>
                <p class="text-gray-500">Silakan masuk untuk melanjutkan</p>
            </div>

            <!-- Form Container -->
            <div class="w-full max-w-md" data-aos="fade-up">
                <div class="bg-white rounded-3xl shadow-xl shadow-indigo-100/50 p-8 border border-gray-100">
                    {{ $slot }}
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center text-sm text-gray-400">
                    &copy; {{ date('Y') }} Sistem Keluhan Mahasiswa. All rights reserved.
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 600, once: true, easing: 'ease-out-cubic' });
    </script>
</body>
</html>
