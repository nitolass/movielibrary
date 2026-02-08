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

                <div class="pt-6">
                    <a href="{{ route('movies.index') }}" class="px-5 py-2 bg-gray-700 hover:bg-gray-600 rounded-xl font-bold transition-colors">← {{ __('Volver') }}</a>
                    <a href="{{ route('movies.edit', $movie) }}" class="ml-2 px-5 py-2 bg-yellow-400 text-black hover:bg-yellow-300 rounded-xl font-bold transition-colors">{{ __('Editar') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
