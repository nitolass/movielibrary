@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-8">

        {{-- CABECERA Y BOTONES --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            {{-- Título --}}
            <div>
                <h1 class="text-3xl font-bold text-white font-['Outfit']">Catálogo <span class="text-yellow-400">MovieHub</span></h1>
                <p class="text-gray-400 text-sm mt-1">Explora las últimas películas añadidas a la plataforma.</p>
            </div>

            {{-- GRUPO DE BOTONES (ORDENAR Y FILTRAR) --}}
            <div class="flex items-center gap-2">

                {{-- 1. BOTÓN ORDENAR POR AÑO (NUEVO) --}}
                <a href="{{ request()->fullUrlWithQuery(['sort' => request('sort') === 'recent' ? null : 'recent']) }}"
                   class="group flex items-center gap-2 text-sm font-bold border rounded-xl py-2.5 px-5 transition-all shadow-sm hover:shadow-md
                   {{ request('sort') === 'recent'
                       ? 'bg-yellow-400/10 border-yellow-400 text-yellow-400'
                       : 'bg-gray-800/50 backdrop-blur-md border-white/10 text-gray-300 hover:bg-white/10 hover:border-yellow-400/30 hover:text-white'
                   }}">
                    {{-- Icono Calendario --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                    <span>Recientes</span>
                </a>

                {{-- 2. BOTÓN DE FILTRAR (EXISTENTE) --}}
                <div x-data="{ open: false }" @click.outside="open = false" class="relative z-20">

                    <button @click="open = !open"
                            class="group flex items-center gap-2 bg-gray-800/50 backdrop-blur-md text-gray-300 text-sm font-bold border border-white/10 rounded-xl py-2.5 px-5 hover:bg-white/10 hover:border-yellow-400/30 hover:text-white transition-all shadow-sm hover:shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 opacity-70 group-hover:opacity-100 transition-opacity">
                            <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
                        </svg>
                        <span>Filtrar</span>

                        {{-- Contador --}}
                        @if(request()->has('genres'))
                            <span class="ml-1 bg-yellow-400 text-black text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                                {{ count(request('genres')) }}
                            </span>
                        @endif

                        {{-- Flechita --}}
                        <svg class="w-4 h-4 ml-1 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    {{-- Menú Desplegable --}}
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         class="absolute right-0 mt-2 w-64 bg-[#1a1d24] border border-white/10 rounded-xl shadow-2xl p-4"
                         style="display: none;">

                        <form method="GET" action="{{ route('user.movies.index') }}">

                            {{-- MANTENER PARÁMETROS: Búsqueda y Orden --}}
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if(request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif

                            <div class="mb-3 text-xs font-bold text-gray-500 uppercase tracking-widest border-b border-white/5 pb-2">
                                Géneros
                            </div>

                            {{-- Lista de Checkboxes --}}
                            <div class="space-y-2 max-h-60 overflow-y-auto custom-scrollbar pr-2 mb-4">
                                @foreach($allGenres as $genre)
                                    <label class="flex items-center space-x-3 cursor-pointer group hover:bg-white/5 p-1 rounded transition-colors">
                                        <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                               class="form-checkbox h-4 w-4 text-yellow-400 rounded border-gray-600 bg-gray-800 focus:ring-yellow-400 focus:ring-offset-gray-900 transition duration-150 ease-in-out"
                                            {{ is_array(request('genres')) && in_array($genre->id, request('genres')) ? 'checked' : '' }}>
                                        <span class="text-gray-300 text-sm group-hover:text-white transition-colors">{{ $genre->name }}</span>
                                    </label>
                                @endforeach
                            </div>

                            {{-- Botones de Acción --}}
                            <div class="flex justify-between items-center gap-2 pt-2 border-t border-white/5">
                                <button type="button"
                                        @click="$el.closest('form').querySelectorAll('input[type=checkbox]').forEach(el => el.checked = false)"
                                        class="text-xs text-gray-500 hover:text-white underline transition-colors">
                                    Limpiar
                                </button>

                                <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-black text-xs font-bold py-2 px-4 rounded-lg transition-colors shadow-lg shadow-yellow-400/20">
                                    Aplicar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> {{-- Fin del Grupo de botones --}}
        </div>

        {{-- GRID DE PELÍCULAS --}}
        @if($movies->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($movies as $movie)
                    <div class="bg-[#16181c] rounded-xl overflow-hidden hover:scale-105 transition-transform duration-300 shadow-lg group relative border border-white/5 hover:border-yellow-400/30">

                        <a href="{{ route('user.movies.show', $movie) }}">
                            <div class="relative aspect-[2/3]">
                                @if($movie->poster)
                                    <img src="{{ asset('storage/' . $movie->poster) }}" class="w-full h-full object-cover" alt="{{ $movie->title }}">
                                @else
                                    <div class="w-full h-full bg-gray-800 flex items-center justify-center text-gray-500 font-bold">
                                        <span class="text-xs">Sin Imagen</span>
                                    </div>
                                @endif

                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="text-white font-bold border border-white px-4 py-2 rounded-full transform scale-90 group-hover:scale-100 transition-transform text-sm">
                                        Ver Detalles
                                    </span>
                                </div>
                            </div>

                            <div class="p-4">
                                <h3 class="text-white font-bold truncate text-sm sm:text-base mb-1" title="{{ $movie->title }}">
                                    {{ $movie->title }}
                                </h3>

                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 text-xs font-medium">{{ $movie->year }}</span>
                                    @if($movie->genres->isNotEmpty())
                                        <span class="text-yellow-400 text-[10px] border border-yellow-400/20 px-1.5 py-0.5 rounded uppercase tracking-wider">
                                            {{ $movie->genres->first()->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $movies->links() }}
            </div>

        @else
            {{-- Mensaje si no hay resultados --}}
            <div class="flex flex-col items-center justify-center py-20 bg-[#16181c]/50 rounded-2xl border border-white/5">
                <div class="bg-gray-800/50 p-6 rounded-full mb-4">
                    <svg class="w-12 h-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">No se encontraron películas</h3>
                <p class="text-gray-400">Intenta ajustar tus filtros o búsqueda.</p>
                @if(request('genres') || request('search') || request('sort'))
                    <a href="{{ route('user.movies.index') }}" class="mt-4 text-yellow-400 hover:text-yellow-300 text-sm font-bold underline">
                        Borrar filtros
                    </a>
                @endif
            </div>
        @endif
    </div>
@endsection
