@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white font-['Outfit']">Historial de Visionado 👀</h1>
            <p class="text-gray-400 text-sm mt-1">Películas que ya has marcado como vistas.</p>
        </div>

        @if($movies && count($movies) > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($movies as $movie)
                    <div class="bg-[#16181c] rounded-xl overflow-hidden hover:scale-105 transition-transform duration-300 shadow-lg group grayscale hover:grayscale-0">
                        <a href="{{ route('', $movie->id) }}">
                            <div class="relative aspect-[2/3]">
                                @if($movie->poster)
                                    <img src="{{ asset('storage/' . $movie->poster) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-800 flex items-center justify-center text-gray-500">Sin img</div>
                                @endif

                                <div class="absolute inset-0 flex items-center justify-center bg-black/40 group-hover:bg-transparent transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white/50 group-hover:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                            <div class="p-3">
                                <h3 class="text-white font-bold truncate">{{ $movie->title }}</h3>
                                <p class="text-gray-500 text-xs">Vista el 20/01/2024</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center h-64 border-2 border-dashed border-gray-700 rounded-xl bg-white/5">
                <p class="text-gray-400 text-lg mb-2">Tu historial está vacío.</p>
                <a href="{{ route('') }}" class="text-yellow-400 hover:text-yellow-300 font-bold text-sm">Empezar a ver &rarr;</a>
            </div>
        @endif
    </div>
@endsection
