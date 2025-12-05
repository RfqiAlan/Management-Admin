@props(['title' => 'Admin', 'header' => 'Dashboard'])

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
        .sidebar-link { 
            display: flex; 
            align-items: center; 
            gap: 0.75rem; 
            padding: 0.75rem 1rem; 
            color: #4b5563; 
            border-radius: 0.75rem; 
            transition: all 0.2s; 
        }
        .sidebar-link:hover { background-color: #eef2ff; color: #4f46e5; }
        .sidebar-link.active { 
            background: linear-gradient(to right, #6366f1, #9333ea); 
            color: white; 
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }
        .sidebar-link.active i { color: white; }
        .sidebar-link i { width: 1.25rem; text-align: center; color: #9ca3af; }
        .sidebar-link.active:hover { background: linear-gradient(to right, #4f46e5, #7c3aed); }
        .glass-card { 
            background-color: rgba(255,255,255,0.8); 
            backdrop-filter: blur(24px); 
            border: 1px solid rgba(255,255,255,0.2); 
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-white to-slate-100" x-data="{ sidebarOpen: true, mobileSidebar: false }">
    <div class="min-h-screen flex">
        <!-- Sidebar Desktop -->
        <aside class="hidden lg:flex lg:flex-col w-72 bg-white border-r border-gray-100 shadow-sm transition-all duration-300"
               :class="{ 'lg:w-72': sidebarOpen, 'lg:w-20': !sidebarOpen }">
            
            <!-- Logo -->
            <div class="h-20 flex items-center px-6 border-b border-gray-100">
                <div class="flex items-center gap-3" :class="{ 'justify-center': !sidebarOpen }">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg" style="box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <div x-show="sidebarOpen" x-transition>
                        <h1 class="font-bold text-gray-800">Admin Panel</h1>
                        <p class="text-xs text-gray-400">Sistem Keluhan</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4" x-show="sidebarOpen">Menu Utama</p>
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i>
                    <span x-show="sidebarOpen">Dashboard</span>
                </a>
                
                <a href="{{ route('admin.complaints.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}">
                    <i class="fas fa-comment-dots"></i>
                    <span x-show="sidebarOpen">Keluhan</span>
                </a>
                
                <a href="{{ route('admin.categories.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-folder-open"></i>
                    <span x-show="sidebarOpen">Kategori</span>
                </a>
                
                <a href="{{ route('admin.users.index') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span x-show="sidebarOpen">Mahasiswa</span>
                </a>

                <div class="pt-6" x-show="sidebarOpen">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Pengaturan</p>
                </div>
                
                <a href="{{ route('admin.settings.whatsapp.edit') }}" 
                   class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fab fa-whatsapp"></i>
                    <span x-show="sidebarOpen">WhatsApp</span>
                </a>

                <a href="{{ route('profile.edit') }}" 
                   class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user-cog"></i>
                    <span x-show="sidebarOpen">Profil</span>
                </a>
            </nav>

            <!-- User Info -->
            <div class="p-4 border-t border-gray-100">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50" :class="{ 'justify-center': !sidebarOpen }">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div x-show="sidebarOpen" x-transition>
                        <p class="text-sm font-medium text-gray-700 truncate" style="max-width: 9rem;">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full sidebar-link text-red-500 hover:bg-red-50 hover:text-red-600 justify-center">
                        <i class="fas fa-sign-out-alt"></i>
                        <span x-show="sidebarOpen">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="mobileSidebar" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-black/50 lg:hidden"
             @click="mobileSidebar = false">
        </div>

        <!-- Mobile Sidebar -->
        <aside x-show="mobileSidebar"
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="fixed inset-y-0 left-0 z-50 w-72 bg-white shadow-2xl lg:hidden flex flex-col">
            
            <!-- Logo -->
            <div class="h-20 flex items-center justify-between px-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-gray-800">Admin Panel</h1>
                        <p class="text-xs text-gray-400">Sistem Keluhan</p>
                    </div>
                </div>
                <button @click="mobileSidebar = false" class="p-2 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-times text-gray-500"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Menu Utama</p>
                
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.complaints.index') }}" class="sidebar-link {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}">
                    <i class="fas fa-comment-dots"></i>
                    <span>Keluhan</span>
                </a>
                
                <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-folder-open"></i>
                    <span>Kategori</span>
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Mahasiswa</span>
                </a>

                <div class="pt-6">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Pengaturan</p>
                </div>
                
                <a href="{{ route('admin.settings.whatsapp.edit') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fab fa-whatsapp"></i>
                    <span>WhatsApp</span>
                </a>

                <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user-cog"></i>
                    <span>Profil</span>
                </a>
            </nav>

            <!-- User Info -->
            <div class="p-4 border-t border-gray-100">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full sidebar-link text-red-500 hover:bg-red-50 hover:text-red-600 justify-center">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen overflow-hidden">
            <!-- Top Header -->
            <header class="h-20 bg-white/80 backdrop-blur-xl border-b border-gray-100 flex items-center justify-between px-6 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <!-- Mobile Menu Button -->
                    <button @click="mobileSidebar = true" class="lg:hidden p-2 rounded-xl hover:bg-gray-100 transition">
                        <i class="fas fa-bars text-gray-600"></i>
                    </button>
                    
                    <!-- Toggle Sidebar Desktop -->
                    <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:flex p-2 rounded-xl hover:bg-gray-100 transition">
                        <i class="fas fa-bars text-gray-600"></i>
                    </button>
                    
                    <!-- Page Title -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $header }}</h2>
                        <p class="text-sm text-gray-400">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Quick Actions -->
                    <a href="{{ route('admin.complaints.index') }}" class="hidden sm:flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl text-sm font-medium shadow-lg hover:shadow-xl transition-all" style="box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);">
                        <i class="fas fa-list"></i>
                        <span>Lihat Keluhan</span>
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 overflow-y-auto">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="py-4 px-6 bg-white/50 border-t border-gray-100 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} Sistem Keluhan Mahasiswa. All rights reserved.
            </footer>
        </div>
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
