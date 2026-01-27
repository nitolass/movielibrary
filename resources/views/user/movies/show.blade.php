@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-8">

        {{-- Botón Volver --}}
        <a href="{{ route('user.movies.index') }}" class="inline-flex items-center text-gray-400 hover:text-white mb-6 transition-colors">
            &larr; Volver al catálogo
        </a>

        <div class="bg-[#16181c] border border-white/5 rounded-2xl overflow-hidden shadow-2xl">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4">

                {{-- COLUMNA 1: PÓSTER --}}
                <div class="relative aspect-[2/3] md:aspect-auto">
                    @if($movie->poster)
                        {{-- Usamos asset storage para sacar la imagen --}}
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

                        {{-- Director --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                            <div>
                                <h4 class="text-sm font-bold text-gray-500 uppercase mb-1">Director</h4>
                                <p class="text-white">{{ $movie->director->name ?? 'Desconocido' }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-500 uppercase mb-1">Duración</h4>
                                <p class="text-white">{{ $movie->duration ?? '---' }} min</p>
                            </div>
                        </div>
                    </div>

                    {{-- ACCIONES DE USUARIO (SOLO BOTONES DE INTERACCIÓN) --}}
                    <div class="flex flex-wrap gap-4 pt-6 border-t border-white/5 items-center">

                        @auth
                            @php
                                // Usamos el helper auth() para no necesitar importar clases arriba
                                $user = auth()->user();

                                // Verificamos si la película está en las listas del usuario
                                $isFavorite   = $user->favorites->contains($movie->id);
                                $isWatchLater = $user->watchLater->contains($movie->id);
                                $isWatched    = $user->watched->contains($movie->id);
                            @endphp

                            {{-- 1. BOTÓN FAVORITOS ❤️ --}}
                            <form action="{{ route('user.toggle.favorite', $movie) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 px-6 py-3 font-bold rounded-xl transition-all border group {{ $isFavorite ? 'bg-red-600 border-red-500 text-white shadow-lg shadow-red-600/20' : 'bg-gray-800 border-gray-700 text-gray-300 hover:text-white hover:border-red-500 hover:bg-gray-700' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $isFavorite ? 'fill-current' : 'group-hover:text-red-500' }}" fill="{{ $isFavorite ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span>{{ $isFavorite ? 'Quitar Favorito' : 'Favoritos' }}</span>
                                </button>
                            </form>

                            {{-- 2. BOTÓN VER MÁS TARDE 🕒 --}}
                            <form action="{{ route('user.toggle.watchLater', $movie) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 px-6 py-3 font-bold rounded-xl transition-all border group {{ $isWatchLater ? 'bg-yellow-500 border-yellow-400 text-black shadow-lg shadow-yellow-500/20' : 'bg-gray-800 border-gray-700 text-gray-300 hover:text-white hover:border-yellow-400 hover:bg-gray-700' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $isWatchLater ? 'fill-current' : 'group-hover:text-yellow-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $isWatchLater ? 'En lista' : 'Ver tarde' }}</span>
                                </button>
                            </form>

                            {{-- 3. BOTÓN YA VISTA ✅ --}}
                            <form action="{{ route('user.toggle.watched', $movie) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 px-6 py-3 font-bold rounded-xl transition-all border group {{ $isWatched ? 'bg-green-600 border-green-500 text-white shadow-lg shadow-green-600/20' : 'bg-gray-800 border-gray-700 text-gray-300 hover:text-white hover:border-green-500 hover:bg-gray-700' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 {{ $isWatched ? '' : 'group-hover:text-green-500' }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $isWatched ? 'Vista' : 'Marcar Vista' }}</span>
                                </button>
                            </form>

                        @else
                            <div class="text-gray-400 text-sm italic bg-white/5 px-4 py-2 rounded-lg border border-white/5">
                                <a href="{{ route('login') }}" class="text-yellow-400 font-bold hover:underline">Inicia sesión</a> para guardar esta película en tus listas.
                            </div>
                        @endauth

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
