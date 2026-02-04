<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MovieHub') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Outfit', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>

    @livewireStyles
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col antialiased">

<div class="fixed inset-0 z-[-10]">
    <img src="{{ asset('images/muchaspeliculas.jpg') }}" alt="Background" class="w-full h-full object-cover opacity-60">
    <div class="absolute inset-0 bg-gradient-to-b from-gray-900/90 via-gray-900/80 to-gray-900"></div>
</div>

<header class="fixed top-0 w-full z-50 transition-all duration-300 backdrop-blur-md bg-black/40 border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center gap-4">

        {{-- 1. LOGO Y NAVEGACIÓN IZQUIERDA --}}
        <div class="flex items-center gap-8">
            <a href="{{ route('welcome') }}" class="text-3xl font-black tracking-tighter text-yellow-400 hover:scale-105 transition-transform drop-shadow-lg">
                MovieHub<span class="text-white">.</span>
            </a>

            <a href="{{ route('user.movies.index') }}" class="hidden md:block text-sm font-bold text-gray-300 hover:text-white transition-colors">
                Catálogo
            </a>
        </div>

        {{-- 2. BARRA DE BÚSQUEDA (LIVEWIRE) --}}
        <div class="flex-1 max-w-2xl px-4">
            <livewire:search-bar />
        </div>

        {{-- 3. MENÚ DE USUARIO --}}
        <div class="flex items-center gap-4">

            @guest
                {{-- INVITADOS --}}
                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold bg-gray-800/80 text-white border border-gray-700 hover:bg-yellow-500 hover:text-black hover:border-yellow-400 transition-all duration-300">
                    Entrar
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="hidden sm:block px-5 py-2.5 rounded-xl text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all duration-300 shadow-[0_0_15px_rgba(255,255,255,0.3)]">
                        Registro
                    </a>
                @endif

            @else
                {{-- USUARIOS LOGUEADOS --}}
                <div x-data="{ open: false }" class="relative">

                    <button @click="open = ! open" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-white/5 transition duration-150 ease-in-out focus:outline-none">
                        <div class="text-right hidden sm:block">
                            <div class="text-sm font-bold text-gray-200">{{ Auth::user()->name }}</div>
                            @if(Auth::user()->role_id == 1)
                                <div class="text-[10px] uppercase tracking-wider text-yellow-400 font-bold">Admin</div>
                            @endif
                        </div>

                        <div class="h-8 w-8 rounded-full bg-yellow-500 flex items-center justify-center text-black font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>

                        <svg class="fill-current h-4 w-4 text-gray-400 transform transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="open"
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-56 rounded-xl shadow-[0_0_30px_rgba(0,0,0,0.8)] bg-[#1a1d24] border border-white/10 py-2 overflow-hidden z-50 divide-y divide-white/5"
                         style="display: none;">

                        @if(Auth::user()->role_id == 1)
                            <div class="px-2 py-2">
                                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm text-yellow-400 font-bold hover:bg-yellow-500/10 hover:text-yellow-300 transition-colors">
                                    ⚡ Panel de Admin
                                </a>
                            </div>
                        @endif

                        <div class="py-2">
                            <div class="px-4 text-[10px] uppercase tracking-wider text-gray-500 font-bold mb-1">Mi Biblioteca</div>
                            <a href="{{ route('user.favorites') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white">❤️ Favoritos</a>
                            <a href="{{ route('user.watch_later') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white">⏱️ Ver más tarde</a>
                            <a href="{{ route('user.watched') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white">👁️ Historial</a>
                            <a href="{{ route('user.rated') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white">⭐ Mis Reseñas</a>
                        </div>

                        <div class="py-2">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white">
                                ⚙️ Configuración
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); this.closest('form').submit();"
                                   class="block px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors">
                                    🚪 Cerrar Sesión
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            @endguest

        </div>
    </div>
</header>

<main class="flex-1 pt-24 pb-12 px-4 md:px-8">
    @if (isset($header))
        <div class="max-w-7xl mx-auto mb-8">
            <h2 class="text-3xl font-black text-white tracking-tight">
                {{ $header }}
            </h2>
        </div>
    @endif

    {{ $slot ?? '' }}

    @yield('content')
</main>

<footer class="py-8 text-center text-gray-600 text-xs border-t border-white/5 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center px-6">
        <span>&copy; {{ date('Y') }} MovieHub Inc. Todos los derechos reservados.</span>
        <div class="mt-2 md:mt-0 flex gap-4">
            <a href="#" class="hover:text-gray-400">Privacidad</a>
            <a href="#" class="hover:text-gray-400">Términos</a>
        </div>
    </div>
</footer>

@livewireScripts

</body>
</html>
