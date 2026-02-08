@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-white font-['Outfit']">{{ __('Editar') }} <span class="text-yellow-400">{{ __('Película') }}</span></h1>
            <a href="{{ route('movies.index') }}" class="text-gray-400 hover:text-white transition-colors">
                &larr; {{ __('Volver') }}
            </a>
        </div>

        <div class="bg-[#0f1115] border border-white/5 rounded-xl p-8 shadow-xl max-w-3xl mx-auto">
            <form action="{{ route('movies.update', $movie) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Título --}}
                <div>
                    <x-label for="title" :value="__('Título de la Película')" />
                    <x-input id="title" type="text" name="title" :value="old('title', $movie->title)" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                {{-- Grid: Año y Director --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-label for="year" :value="__('Año de Estreno')" />
                        <x-input id="year" type="number" name="year" :value="old('year', $movie->year)" required />
                        <x-input-error :messages="$errors->get('year')" class="mt-2" />
                    </div>

                    {{-- Selector de Director --}}
                    <div>
                        <x-label for="director_id" :value="__('Director')" />
                        <x-select name="director_id" required>
                            <option value="" disabled>{{ __('Selecciona un director...') }}</option>
                            @foreach($directors as $director)
                                <option value="{{ $director->id }}"
                                    {{ old('director_id', $movie->director_id) == $director->id ? 'selected' : '' }}>
                                    {{ $director->name }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error :messages="$errors->get('director_id')" class="mt-2" />
                    </div>
                </div>

                {{-- Sinopsis --}}
                <div>
                    <x-label for="description" :value="__('Sinopsis')" />
                    <x-textarea id="description" name="description" rows="5" required>{{ old('description', $movie->description) }}</x-textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                {{-- Géneros (Checkboxes) --}}
                <div>
                    <x-label :value="__('Géneros')" class="mb-3" />
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach($genres as $genre)
                            <label class="flex items-center space-x-3 p-3 bg-[#16181c] border border-gray-700 rounded-xl hover:border-yellow-400/50 cursor-pointer transition-colors">
                                <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                       class="rounded bg-gray-800 border-gray-600 text-yellow-400 focus:ring-yellow-400 focus:ring-offset-gray-900"
                                    {{ in_array($genre->id, old('genres', $movie->genres->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <span class="text-gray-300 text-sm font-bold">{{ $genre->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('genres')" class="mt-2" />
                </div>

                {{-- Poster --}}
                <div>
                    <x-label for="poster" :value="__('Cambiar Póster (Opcional)')" />

                    @if($movie->poster)
                        <div class="mb-3">
                            <p class="text-xs text-gray-500 mb-1">{{ __('Póster Actual:') }}</p>
                            <img src="{{ asset('storage/' . $movie->poster) }}" alt="Poster actual" class="h-32 w-auto object-cover rounded-lg border border-gray-700 shadow-lg">
                        </div>
                    @endif

                    <x-input id="poster" type="file" name="poster" class="py-2" />
                    <x-input-error :messages="$errors->get('poster')" class="mt-2" />
                </div>

                {{-- Botones --}}
                <div class="flex justify-end gap-4 pt-4 border-t border-white/5">
                    <a href="{{ route('movies.index') }}" class="px-6 py-3 bg-gray-800 text-gray-300 font-bold rounded-xl hover:bg-gray-700 transition-colors">
                        {{ __('Cancelar') }}
                    </a>
                    <x-button>
                        {{ __('Actualizar Película') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
@endsection
