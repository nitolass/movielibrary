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
        body {
            font-family: 'Outfit', sans-serif;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1a1a1a;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #444;
            border-radius: 4px;
        }
    </style>
</head>
<body class="bg-[#16181c] text-gray-100 min-h-screen antialiased" x-data="{ sidebarOpen: false }">


<div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
     class="fixed inset-y-0 left-0 z-50 w-64 transition-transform duration-300 md:translate-x-0 bg-[#0f1115] border-r border-white/5">

    @if(Auth::user() && (Auth::user()->email === 'juan@admin.es' || (Auth::user()->role && Auth::user()->role->name === 'admin')))
        @include('layouts.sidebar_admin')
    @else
        @include('layouts.sidebar_client')
    @endif

</div>

<div x-show="sidebarOpen" @click="sidebarOpen = false"
     class="fixed inset-0 bg-black/50 z-40 md:hidden backdrop-blur-sm"></div>

<div class="flex-1 flex flex-col min-h-screen transition-all duration-300 md:ml-64">

    <header
        class="h-20 flex items-center justify-between px-6 py-4 bg-[#0f1115]/80 backdrop-blur-md sticky top-0 z-30 border-b border-white/5">

        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-400 hover:text-white focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <div class="hidden md:flex items-center w-full max-w-md relative mx-4">
            <svg class="absolute left-4 w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" placeholder="Buscar películas, géneros..."
                   class="w-full bg-[#1e2126] border-transparent focus:border-yellow-400/50 text-gray-200 text-sm rounded-full pl-12 pr-4 py-2.5 focus:ring-0 transition-all placeholder-gray-500">
        </div>

        <div class="flex items-center gap-4 ml-auto">
            <button class="relative p-2 text-gray-400 hover:text-white transition-colors rounded-full hover:bg-white/5">
                <div class="absolute top-2 right-2 w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </button>

            <div class="w-8 h-8 rounded-full bg-yellow-500 flex items-center justify-center text-black font-bold">
                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
            </div>
        </div>
    </header>

    <main class="flex-1 p-6 md:p-8">
        @yield('content')
        {{ $slot ?? '' }}
    </main>
</div>
</body>
</html>
