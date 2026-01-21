@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-white mb-2 font-['Outfit']">{{ $title }}</h1>
        <p class="text-gray-400 mb-8">Gestiona tu lista personal.</p>

        @if($movies && count($movies) > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($movies as $movie)
                    <div class="bg-[#16181c] rounded-xl overflow-hidden hover:scale-105 transition-transform duration-300 shadow-lg group">
                        <a href="{{ route('public.movies.show', $movie->id) }}">
                            <div class="relative aspect-[2/3]">
                                @if($movie->poster)
                                    <img src="{{ asset('storage/' . $movie->poster) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-800 flex items-center justify-center text-gray-500">Sin img</div>
                                @endif

                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="text-white font-bold border border-white px-4 py-2 rounded-full">Ver Ficha</span>
                                </div>
                            </div>
                            <div class="p-3">
                                <h3 class="text-white font-bold truncate">{{ $movie->title }}</h3>
                                <p class="text-gray-500 text-xs">{{ $movie->year }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center h-64 border-2 border-dashed border-gray-700 rounded-xl bg-white/5">
                <svg class="w-16 h-16 text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <p class="text-gray-400 text-lg">Aún no tienes películas aquí.</p>
                <a href="{{ route('') }}" class="mt-2 text-yellow-400 hover:text-yellow-300 font-bold text-sm">Explorar catálogo &rarr;</a>
            </div>
        @endif
    </div>
@endsection
