@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white font-['Outfit']">Mis Puntuaciones ⭐</h1>
            <p class="text-gray-400 text-sm mt-1">Las películas que has valorado.</p>
        </div>

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

                                <div class="absolute top-2 right-2 bg-yellow-400 text-black text-xs font-bold px-2 py-1 rounded">
                                    ★ 5.0
                                </div>
                            </div>
                            <div class="p-3">
                                <h3 class="text-white font-bold truncate">{{ $movie->title }}</h3>
                                <p class="text-gray-500 text-xs">Tu reseña: "Increíble..."</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center h-64 border-2 border-dashed border-gray-700 rounded-xl bg-white/5">
                <p class="text-gray-400 text-lg mb-2">Aún no has puntuado nada.</p>
                <a href="{{ route('public.movies.index') }}" class="text-yellow-400 hover:text-yellow-300 font-bold text-sm">Ir a puntuar &rarr;</a>
            </div>
        @endif
    </div>
@endsection
