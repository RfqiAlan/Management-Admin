<nav x-data="{ open: false }" class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- BRAND + MENU --}}
            <div class="flex items-center space-x-8">
                {{-- Brand --}}
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <span class="text-lg font-semibold text-indigo-600">
                        Sistem Keluhan Mahasiswa
                    </span>
                </a>

                {{-- Menu desktop --}}
                @auth
                    <div class="hidden sm:flex sm:items-center sm:space-x-6 text-sm">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                               class="border-b-2 pb-1 {{ request()->routeIs('admin.dashboard') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.complaints.index') }}"
                               class="border-b-2 pb-1 {{ request()->routeIs('admin.complaints.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300' }}">
                                Keluhan
                            </a>
                            <a href="{{ route('admin.categories.index') }}"
                               class="border-b-2 pb-1 {{ request()->routeIs('admin.categories.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300' }}">
                                Kategori
                            </a>
                            <a href="{{ route('admin.users.index') }}"
                               class="border-b-2 pb-1 {{ request()->routeIs('admin.users.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300' }}">
                                Mahasiswa
                            </a>
                            <a href="{{ route('admin.settings.whatsapp.edit') }}"
                               class="border-b-2 pb-1 {{ request()->routeIs('admin.settings.whatsapp.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300' }}">
                                Pengaturan WA
                            </a>
                        @elseif(auth()->user()->isStudent())
                            <a href="{{ route('student.complaints.index') }}"
                               class="border-b-2 pb-1 {{ request()->routeIs('student.complaints.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-gray-300' }}">
                                Keluhan Saya
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            {{-- USER + LOGOUT (desktop) --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                @auth
                    <span class="text-sm text-gray-700">
                        {{ auth()->user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="text-sm text-red-600 hover:text-red-700 font-medium">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm text-gray-700 hover:text-indigo-600">
                        Masuk
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="text-sm text-gray-700 hover:text-indigo-600">
                            Daftar
                        </a>
                    @endif
                @endauth
            </div>

            {{-- HAMBURGER (mobile) --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }"
                              class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENU MOBILE --}}
    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden border-t border-gray-200 bg-white">
        <div class="pt-2 pb-3 space-y-1 px-4 text-sm">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="block py-1 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.complaints.index') }}"
                       class="block py-1 {{ request()->routeIs('admin.complaints.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                        Keluhan
                    </a>
                    <a href="{{ route('admin.categories.index') }}"
                       class="block py-1 {{ request()->routeIs('admin.categories.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                        Kategori
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                       class="block py-1 {{ request()->routeIs('admin.users.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                        Mahasiswa
                    </a>
                    <a href="{{ route('admin.settings.whatsapp.edit') }}"
                       class="block py-1 {{ request()->routeIs('admin.settings.whatsapp.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                        Pengaturan WA
                    </a>
                @elseif(auth()->user()->isStudent())
                    <a href="{{ route('student.complaints.index') }}"
                       class="block py-1 {{ request()->routeIs('student.complaints.*') ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                        Keluhan Saya
                    </a>
                @endif
            @endauth
        </div>

        {{-- user + logout mobile --}}
        <div class="border-t border-gray-100 px-4 py-3">
            @auth
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-800">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ auth()->user()->email }}
                        </p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="text-xs text-red-600 hover:text-red-700 font-medium">
                            Keluar
                        </button>
                    </form>
                </div>
            @else
                <div class="flex items-center justify-between">
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-indigo-600">
                        Masuk
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm text-gray-700 hover:text-indigo-600">
                            Daftar
                        </a>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>
