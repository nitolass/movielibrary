@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-8">

        {{-- Botón Volver --}}
        <a href="{{ route('user.movies.index') }}" class="inline-flex items-center text-gray-400 hover:text-white mb-6 transition-colors">
            &larr; Volver al catálogo
        </a>

        {{-- 1. FICHA PRINCIPAL DE LA PELÍCULA --}}
        <div class="bg-[#16181c] border border-white/5 rounded-2xl overflow-hidden shadow-2xl mb-12">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4">

                {{-- COLUMNA 1: PÓSTER --}}
                <div class="relative aspect-[2/3] md:aspect-auto">
                    @if($movie->poster)
                        <img src="{{ asset('storage/' . $movie->poster) }}" alt=" w-full h-full object-cover">
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

                    {{-- ACCIONES DE USUARIO --}}
                    <div class="flex flex-wrap gap-4 pt-6 border-t border-white/5 items-center">
                        @auth
                            @php
                                $user = auth()->user();
                                $isFavorite   = $user->favorites->contains($movie->id);
                                $isWatchLater = $user->watchLater->contains($movie->id);
                                $isWatched    = $user->watched->contains($movie->id);
                            @endphp

                            {{-- Favoritos --}}
                            <form action="{{ route('user.toggle.favorite', $movie) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 px-6 py-3 font-bold rounded-xl transition-all border group {{ $isFavorite ? 'bg-red-600 border-red-500 text-white shadow-lg shadow-red-600/20' : 'bg-gray-800 border-gray-700 text-gray-300 hover:text-white hover:border-red-500 hover:bg-gray-700' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $isFavorite ? 'fill-current' : 'group-hover:text-red-500' }}" fill="{{ $isFavorite ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span>{{ $isFavorite ? 'Quitar' : 'Favoritos' }}</span>
                                </button>
                            </form>

                            {{-- Ver Tarde --}}
                            <form action="{{ route('user.toggle.watchLater', $movie) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 px-6 py-3 font-bold rounded-xl transition-all border group {{ $isWatchLater ? 'bg-yellow-500 border-yellow-400 text-black shadow-lg shadow-yellow-500/20' : 'bg-gray-800 border-gray-700 text-gray-300 hover:text-white hover:border-yellow-400 hover:bg-gray-700' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $isWatchLater ? 'fill-current' : 'group-hover:text-yellow-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $isWatchLater ? 'En lista' : 'Ver tarde' }}</span>
                                </button>
                            </form>

                            {{-- Vista --}}
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
                                <a href="{{ route('login') }}" class="text-yellow-400 font-bold hover:underline">Inicia sesión</a> para guardar esta película.
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. SECCIÓN DE RESEÑAS --}}
        <div class="mt-8 border-t border-white/10 pt-8">
            <h3 class="text-3xl font-bold text-white mb-8 flex items-center gap-2">
                Reseñas de la Comunidad <span class="text-yellow-400">.</span>
            </h3>

            {{-- FORMULARIO DE RESEÑA (Solo Auth) --}}
            @auth
                <div class="bg-[#16181c] border border-white/5 p-6 rounded-2xl mb-10 shadow-lg">
                    <h4 class="text-lg font-bold text-yellow-400 mb-4">¿Qué te ha parecido?</h4>

                    <form action="{{ route('reviews.store', $movie->id) }}" method="POST">
                        @csrf
                        <div class="flex flex-col md:flex-row gap-4 mb-4">
                            {{-- Estrellas --}}
                            <div class="w-full md:w-1/4">
                                <label class="block text-gray-400 text-sm font-bold mb-2">Puntuación</label>
                                <select name="rating" class="w-full bg-[#0f1115] text-white border border-gray-700 rounded-xl p-3 focus:border-yellow-400 outline-none transition-colors">
                                    <option value="5">⭐⭐⭐⭐⭐ Excelente</option>
                                    <option value="4">⭐⭐⭐⭐ Muy buena</option>
                                    <option value="3">⭐⭐⭐ Normal</option>
                                    <option value="2">⭐⭐ Mala</option>
                                    <option value="1">⭐ Terrible</option>
                                </select>
                            </div>

                            {{-- Comentario --}}
                            <div class="w-full md:w-3/4">
                                <label class="block text-gray-400 text-sm font-bold mb-2">Tu opinión</label>
                                <textarea name="content" rows="3" placeholder="Comparte tu opinión con la comunidad..." class="w-full bg-[#0f1115] text-white border border-gray-700 rounded-xl p-3 focus:border-yellow-400 outline-none transition-colors" required></textarea>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="px-6 py-2 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-500 transition-all shadow-[0_0_15px_rgba(250,204,21,0.3)] transform hover:-translate-y-0.5">
                                Publicar Reseña
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="bg-[#16181c] border border-white/5 p-8 rounded-2xl text-center mb-10">
                    <p class="text-gray-400 text-lg">
                        Debes <a href="{{ route('login') }}" class="text-yellow-400 font-bold hover:underline">iniciar sesión</a> para escribir una reseña.
                    </p>
                </div>
            @endauth

            {{-- LISTA DE RESEÑAS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($movie->reviews as $review)
                    <div class="bg-[#16181c] border border-white/5 p-6 rounded-2xl hover:border-yellow-400/20 transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                {{-- Avatar con inicial --}}
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-yellow-400 to-yellow-600 flex items-center justify-center text-black font-bold text-lg shadow-lg shadow-yellow-500/20">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-white">{{ $review->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="text-yellow-400 tracking-wide text-sm">
                                @for($i=0; $i < $review->rating; $i++) ★ @endfor
                            </div>
                        </div>
                        <p class="text-gray-300 text-sm leading-relaxed bg-[#0f1115] p-4 rounded-xl border border-white/5 italic">
                            "{{ $review->content }}"
                        </p>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center border border-dashed border-white/10 rounded-2xl">
                        <p class="text-gray-500 italic">No hay reseñas para esta película aún. ¡Sé el primero!</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection
