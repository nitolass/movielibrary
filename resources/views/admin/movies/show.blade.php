@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-10 text-white max-w-4xl">

        <div class="bg-[#0f1115] rounded-3xl overflow-hidden shadow-2xl border border-white/5 flex flex-col md:flex-row">

            {{-- Columna Imagen --}}
            <div class="w-full md:w-1/3 bg-black/50">
                @if($movie->poster)
                    <img src="{{ asset('storage/'.$movie->poster) }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-800 text-gray-500">{{ __('Sin Imagen') }}</div>
                @endif
            </div>

            {{-- Columna Info --}}
            <div class="w-full md:w-2/3 p-8 space-y-4">
                <h1 class="text-4xl font-black text-white font-['Outfit']">{{ $movie->title }} <span class="text-yellow-400 text-2xl">({{ $movie->year }})</span></h1>

                <div class="flex flex-wrap gap-2 text-xs font-bold uppercase text-gray-400">
                    <span class="bg-gray-800 px-2 py-1 rounded">{{ $movie->duration }} min</span>
                    <span class="bg-gray-800 px-2 py-1 rounded">+{{ $movie->age_rating }}</span>
                    <span class="bg-gray-800 px-2 py-1 rounded">{{ $movie->country }}</span>
                </div>

                <p class="text-gray-300 leading-relaxed">{{ $movie->description }}</p>

                <div class="pt-4 space-y-2 border-t border-white/10">
                    <p class="text-sm"><strong class="text-yellow-400 uppercase text-xs">{{ __('Director') }}:</strong>
                        {{ $movie->director ? $movie->director->name : __('Sin director asignado') }}
                    </p>

                    <p class="text-sm"><strong class="text-yellow-400 uppercase text-xs">{{ __('Géneros') }}:</strong>
                        {{ $movie->genres->pluck('name')->join(', ') }}
                    </p>

                    <p class="text-sm"><strong class="text-yellow-400 uppercase text-xs">{{ __('Actores') }}:</strong>
                        {{ $movie->actors->pluck('name')->join(', ') }}
                    </p>
                </div>
                <div class="pt-6 border-t border-white/10 flex flex-row items-center gap-3">
                    {{-- 1. Botón Volver --}}
                    <a href="{{ route('movies.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-xl font-bold transition-colors text-sm">
                        <span>←</span> {{ __('Volver') }}
                    </a>

                    {{-- 2. Botón Editar --}}
                    <a href="{{ route('movies.edit', $movie) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-yellow-400 text-black hover:bg-yellow-300 rounded-xl font-bold transition-colors text-sm shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        {{ __('Editar') }}
                    </a>

                    {{-- 3. Botón PDF --}}
                    <a href="{{ route('admin.pdf.movie', $movie) }}" target="_blank"
                       class="inline-flex items-center gap-2 px-5 py-2.5 border border-red-500/50 text-red-400 hover:bg-red-600 hover:text-white rounded-xl font-bold transition-all text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        {{ __('PDF') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
