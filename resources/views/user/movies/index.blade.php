@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white font-['Outfit']">Catálogo <span class="text-yellow-400">MovieHub</span></h1>
                <p class="text-gray-400 text-sm mt-1">Explora las últimas películas añadidas a la plataforma.</p>
            </div>

            {{-- Aquí irán los filtros en el futuro --}}
        </div>

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

                                    {{-- Mostramos el primer género si existe --}}
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
            <div class="flex flex-col items-center justify-center py-20 bg-[#16181c]/50 rounded-2xl border border-white/5">
                <div class="bg-gray-800/50 p-6 rounded-full mb-4">
                    <svg class="w-12 h-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Aún no hay películas</h3>
                <p class="text-gray-400">El catálogo se está actualizando.</p>
            </div>
        @endif
    </div>
@endsection
