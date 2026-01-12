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
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col antialiased">

<div class="fixed inset-0 z-[-10]">
    <img src="{{ asset('images/muchaspeliculas.jpg') }}" alt="Background" class="w-full h-full object-cover opacity-60">
    <div class="absolute inset-0 bg-gradient-to-b from-gray-900/90 via-gray-900/80 to-gray-900"></div>
</div>

<header class="fixed top-0 w-full z-50 transition-all duration-300 backdrop-blur-md bg-black/30 border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">

        <a href="{{ url('/') }}" class="text-3xl font-black tracking-tighter text-yellow-400 hover:scale-105 transition-transform drop-shadow-lg">
            {{ config('app.name', 'MovieHub') }}
        </a>

        <div class="flex items-center gap-4">
            @guest
                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold bg-gray-800/80 text-white border border-gray-700 hover:bg-yellow-500 hover:text-black hover:border-yellow-400 transition-all duration-300">
                    Iniciar Sesión
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold bg-white text-black hover:bg-gray-200 transition-all duration-300 shadow-[0_0_15px_rgba(255,255,255,0.3)]">
                        Registrarse
                    </a>
                @endif
            @else
                <div x-data="{ open: false }" class="relative">

                    <button @click="open = ! open" class="flex items-center gap-2 px-3 py-2 text-sm font-bold text-gray-200 hover:text-yellow-400 transition duration-150 ease-in-out focus:outline-none">
                        <span>{{ Auth::user()->name }}</span>
                        <div class="ml-1">
                            <svg class="fill-current h-4 w-4 transform transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="open"
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 rounded-xl shadow-[0_0_20px_rgba(0,0,0,0.5)] bg-gray-800 border border-white/10 py-1 overflow-hidden z-50"
                         style="display: none;">

                        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors border-b border-gray-700">
                            {{ __('Mi Perfil') }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="block px-4 py-3 text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors">
                                {{ __('Cerrar Sesión') }}
                            </a>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</header>

<main class="flex-1 pt-24 pb-12 px-6">
    @if (isset($header))
        <div class="max-w-7xl mx-auto mb-6">
            <div class="text-2xl font-bold text-white">
                {{ $header }}
            </div>
        </div>
    @endif

    {{ $slot ?? '' }}

    @yield('content')
</main>

<footer class="py-6 text-center text-gray-500 text-sm border-t border-white/5 backdrop-blur-sm">
    &copy; {{ date('Y') }} {{ config('app.name') }}.
</footer>

</body>
</html>
