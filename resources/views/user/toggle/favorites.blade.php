@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white font-['Outfit']">Mis Favoritos ❤️</h1>
            <p class="text-gray-400 text-sm mt-1">Las películas que más te gustan están aquí.</p>
        </div>

        @if($movies && count($movies) > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($movies as $movie)
                    <div class="bg-[#16181c] rounded-xl overflow-hidden hover:scale-105 transition-transform duration-300 shadow-lg group relative">

                        <a href="{{ route('user.movies.show', $movie) }}">

                            <div class="relative aspect-[2/3]">
                                @if($movie->poster)
                                    <img src="{{ asset('storage/' . $movie->poster) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-800 flex items-center justify-center text-gray-500">Sin img</div>
                                @endif

                                {{-- Hover: Ver Ficha --}}
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="text-white font-bold border border-white px-4 py-2 rounded-full">Ver Ficha</span>
                                </div>
                            </div>

                            <div class="p-3">
                                <h3 class="text-white font-bold truncate">{{ $movie->title }}</h3>
                                <div class="flex justify-between items-center mt-1">
                                    <p class="text-gray-500 text-xs">{{ $movie->year }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center h-64 border-2 border-dashed border-gray-700 rounded-xl bg-white/5">
                <p class="text-gray-400 text-lg mb-2">No tienes favoritos aún.</p>
                <a href="{{ route('user.movies.index') }}" class="text-yellow-400 hover:text-yellow-300 font-bold text-sm">Explorar catálogo &rarr;</a>
            </div>
        @endif
    </div>
@endsection
