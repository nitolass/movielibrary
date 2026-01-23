@extends('layouts.app')

@section('title', 'Bienvenido - MovieHub')

@section('content')
    <div class="relative w-full min-h-screen bg-[#0f1115] text-white overflow-hidden font-['Outfit'] selection:bg-yellow-400 selection:text-black flex flex-col justify-center items-center" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">

        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('https://www.transparenttextures.com/patterns/stardust.png');"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-yellow-500/10 rounded-full blur-[128px]"></div>
            <div class="absolute -bottom-24 -left-24 w-[500px] h-[500px] bg-purple-900/20 rounded-full blur-[128px]"></div>
        </div>

        <div class="relative z-10 flex flex-col justify-center items-center text-center px-4 md:px-6 max-w-4xl mx-auto">

            <div class="mb-10 text-4xl md:text-5xl font-black tracking-tighter transition-all duration-700 opacity-0 -translate-y-4" :class="loaded ? 'translate-y-0 opacity-100' : ''">
                MovieHub<span class="text-yellow-400">.</span>
            </div>

            <div class="mb-8 inline-block transition-all duration-700 delay-100 opacity-0 translate-y-4" :class="loaded ? 'translate-y-0 opacity-100' : ''">
            <span class="px-4 py-1.5 rounded-full border border-yellow-400/30 bg-yellow-400/10 text-yellow-400 text-xs font-bold uppercase tracking-widest shadow-[0_0_15px_rgba(250,204,21,0.2)] backdrop-blur-md">
                La experiencia definitiva
            </span>
            </div>

            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black mb-6 leading-tight tracking-tight transition-all duration-700 delay-200 opacity-0 translate-y-4" :class="loaded ? 'translate-y-0 opacity-100' : ''">
                Descubre, opina y <br class="hidden md:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-200 to-amber-500 drop-shadow-lg">
                colecciona cine.
            </span>
            </h1>

            <p class="text-lg md:text-xl text-gray-400 mb-12 max-w-2xl mx-auto leading-relaxed transition-all duration-700 delay-300 opacity-0 translate-y-4" :class="loaded ? 'translate-y-0 opacity-100' : ''">
                Tu biblioteca personal de películas. Sin distracciones, solo cine.
            </p>

            <div class="flex flex-col sm:flex-row items-center gap-6 transition-all duration-700 delay-400 opacity-0 translate-y-4" :class="loaded ? 'translate-y-0 opacity-100' : ''">

                <a href="{{ route('user.movies.index') }}" class="group relative px-10 py-5 bg-yellow-400 text-black font-black text-lg rounded-full shadow-[0_0_20px_rgba(250,204,21,0.4)] hover:shadow-[0_0_50px_rgba(250,204,21,0.6)] hover:-translate-y-1 transition-all duration-300 flex items-center gap-3 overflow-hidden">
                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/40 to-transparent -translate-x-[150%] group-hover:translate-x-[150%] transition-transform duration-700 ease-in-out"></span>
                    <span class="relative">Explorar Catálogo</span>
                    <svg class="w-5 h-5 relative group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </a>

                @guest
                    <div class="flex items-center gap-6 text-sm font-bold">
                        <a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2 group">
                            Crear cuenta
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </a>
                        <span class="text-gray-700">|</span>
                        <a href="{{ route('login') }}" class="text-gray-400 hover:text-yellow-400 transition-colors">
                            Ya tengo cuenta
                        </a>
                    </div>
                @endguest
            </div>

        </div>

        <div class="absolute bottom-6 w-full text-center text-gray-700 text-[10px] uppercase tracking-widest transition-all duration-1000 delay-700 opacity-0" :class="loaded ? 'opacity-100' : ''">
            &copy; {{ date('Y') }} MovieHub Inc.
        </div>

    </div>
@endsection
