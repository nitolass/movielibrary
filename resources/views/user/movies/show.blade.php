@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-8">

        {{-- Botón Volver --}}
        <a href="{{ route('public.movies.index') }}" class="inline-flex items-center text-gray-400 hover:text-white mb-6 transition-colors">
            &larr; Volver al catálogo
        </a>

        <div class="bg-[#16181c] border border-white/5 rounded-2xl overflow-hidden shadow-2xl">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4">

                {{-- COLUMNA 1: PÓSTER --}}
                <div class="relative aspect-[2/3] md:aspect-auto">
                    @if($movie->poster)
                        <img src="{{ asset('storage/' . $movie->poster) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-800 flex items-center justify-center text-gray-500 font-bold">Sin Imagen</div>
                    @endif
                </div>

                {{-- COLUMNA 2: INFORMACIÓN --}}
                <div class="p-8 md:col-span-2 lg:col-span-3 flex flex-col justify-between">
                    <div>
                        {{-- Título y Año --}}
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                            <h1 class="text-4xl font-bold text-white font-['Outfit']">{{ $movie->title }}</h1>
                            <span class="bg-yellow-400 text-black font-bold px-3 py-1 rounded-lg text-sm w-fit">
                                {{ $movie->year }}
                            </span>
                        </div>

                        {{-- Géneros --}}
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($movie->genres as $genre)
                                <span class="text-xs font-bold text-gray-300 border border-gray-600 px-2 py-1 rounded-full">
                                    {{ $genre->name }}
                                </span>
                            @endforeach
                        </div>

                        {{-- Sinopsis --}}
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-white mb-2">Sinopsis</h3>
                            <p class="text-gray-400 leading-relaxed">
                                {{ $movie->description }}
                            </p>
                        </div>

                        {{-- Director y Reparto (Si tienes relaciones) --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                            <div>
                                <h4 class="text-sm font-bold text-gray-500 uppercase mb-1">Director</h4>
                                <p class="text-white">{{ $movie->director->name ?? 'Desconocido' }}</p>
                            </div>

                            {{-- Ejemplo si tuvieras actores --}}
                            {{--
                            <div>
                                <h4 class="text-sm font-bold text-gray-500 uppercase mb-1">Reparto Principal</h4>
                                <p class="text-white text-sm">
                                    @foreach($movie->actors->take(3) as $actor)
                                        {{ $actor->name }}{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                </p>
                            </div>
                            --}}
                        </div>
                    </div>

                    {{-- ACCIONES DE USUARIO (Favoritos / Ver más tarde) --}}
                    <div class="flex flex-wrap gap-4 pt-6 border-t border-white/5">

                        {{-- Botón Favoritos (Simulado) --}}
                        <button class="flex items-center gap-2 px-6 py-3 bg-gray-800 text-white font-bold rounded-xl hover:bg-gray-700 hover:text-red-400 transition-all border border-gray-700 group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:fill-current transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span>Añadir a Favoritos</span>
                        </button>

                        {{-- Botón Ver más tarde (Simulado) --}}
                        <button class="flex items-center gap-2 px-6 py-3 bg-gray-800 text-white font-bold rounded-xl hover:bg-gray-700 hover:text-yellow-400 transition-all border border-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Ver más tarde</span>
                        </button>

                        {{-- Si es ADMIN, mostrar botón de editar --}}
                        @if(Auth::user()->role && Auth::user()->role->name === 'admin')
                            <a href="{{ route('movies.edit', $movie) }}" class="ml-auto flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-500 transition-all shadow-lg shadow-blue-600/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Editar Película
                            </a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
