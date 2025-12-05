@props(['title' => 'Dashboard', 'header' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .nav-link { 
            display: flex; 
            align-items: center; 
            gap: 0.5rem; 
            padding: 0.5rem 1rem; 
            color: #4b5563; 
            border-radius: 0.75rem; 
            transition: all 0.2s; 
            font-size: 0.875rem; 
            font-weight: 500; 
        }
        .nav-link:hover { background-color: #eef2ff; color: #4f46e5; }
        .nav-link.active { 
            background: linear-gradient(to right, #6366f1, #9333ea); 
            color: white; 
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.25);
        }
        .glass-card { 
            background-color: rgba(255,255,255,0.8); 
            backdrop-filter: blur(24px); 
            border: 1px solid rgba(255,255,255,0.2); 
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            border-radius: 1rem;
        }
        .gradient-text { 
            background: linear-gradient(to right, #4f46e5, #9333ea); 
            -webkit-background-clip: text; 
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen">
    <!-- Animated Background -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 4s;"></div>
    </div>

    <div class="min-h-screen flex flex-col">
        <!-- Navigation Header -->
        <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-100/50 shadow-sm" x-data="{ mobileMenu: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <a href="{{ route('student.complaints.index') }}" class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg" style="box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);">
                            <i class="fas fa-graduation-cap text-white"></i>
                        </div>
                        <div class="hidden sm:block">
                            <h1 class="font-bold text-gray-800">Portal Mahasiswa</h1>
                            <p class="text-xs text-gray-400">Sistem Keluhan</p>
                        </div>
                    </a>

                    <!-- Desktop Navigation -->
                    <nav class="hidden md:flex items-center gap-2">
                        <a href="{{ route('student.complaints.index') }}" 
                           class="nav-link {{ request()->routeIs('student.complaints.index') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('student.complaints.create') }}" 
                           class="nav-link {{ request()->routeIs('student.complaints.create') ? 'active' : '' }}">
                            <i class="fas fa-plus-circle"></i>
                            <span>Buat Keluhan</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" 
                           class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <i class="fas fa-user-circle"></i>
                            <span>Profil</span>
                        </a>
                    </nav>

                    <!-- User Menu -->
                    <div class="flex items-center gap-4">
                        <div class="hidden sm:flex items-center gap-3 px-4 py-2 bg-gray-50 rounded-xl">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-sm font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden lg:block">
                                <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400">Mahasiswa</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-2 rounded-xl text-gray-500 hover:bg-red-50 hover:text-red-500 transition">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>

                        <!-- Mobile Menu Button -->
                        <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 rounded-xl hover:bg-gray-100 transition">
                            <i class="fas" :class="mobileMenu ? 'fa-times' : 'fa-bars'"></i>
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation -->
                <div x-show="mobileMenu" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-4"
                     class="md:hidden py-4 border-t border-gray-100">
                    <nav class="space-y-2">
                        <a href="{{ route('student.complaints.index') }}" 
                           class="nav-link {{ request()->routeIs('student.complaints.index') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('student.complaints.create') }}" 
                           class="nav-link {{ request()->routeIs('student.complaints.create') ? 'active' : '' }}">
                            <i class="fas fa-plus-circle"></i>
                            <span>Buat Keluhan</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" 
                           class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <i class="fas fa-user-circle"></i>
                            <span>Profil</span>
                        </a>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-6 bg-white/50 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-sm text-gray-400">&copy; {{ date('Y') }} Sistem Keluhan Mahasiswa. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        AOS.init({ duration: 600, once: true, easing: 'ease-out-cubic' });

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                toast: true,
                position: 'top-end'
            });
        @elseif(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                toast: true,
                position: 'top-end'
            });
        @endif
    </script>
</body>
</html>
