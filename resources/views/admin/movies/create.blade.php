@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-white font-['Outfit']">Nueva <span class="text-yellow-400">Película</span></h1>
            <a href="{{ route('movies.index') }}" class="text-gray-400 hover:text-white transition-colors">
                &larr; Volver
            </a>
        </div>

        <div class="bg-[#0f1115] border border-white/5 rounded-xl p-8 shadow-xl max-w-3xl mx-auto">
            <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Título --}}
                <div>
                    <x-label for="title" value="Título de la Película" />
                    <x-input id="title" type="text" name="title" :value="old('title')" required placeholder="Ej: Inception" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                {{-- Grid: Año y Director --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-label for="year" value="Año de Estreno" />
                        <x-input id="year" type="number" name="year" :value="old('year')" required placeholder="Ej: 2010" />
                        <x-input-error :messages="$errors->get('year')" class="mt-2" />
                    </div>

                    {{-- Selector de Director --}}
                    <div>
                        <x-label for="director_id" value="Director" />
                        <x-select name="director_id" required>
                            <option value="" disabled selected>Selecciona un director...</option>
                            @foreach($directors as $director)
                                <option value="{{ $director->id }}" {{ old('director_id') == $director->id ? 'selected' : '' }}>
                                    {{ $director->name }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error :messages="$errors->get('director_id')" class="mt-2" />
                    </div>
                </div>

                {{-- Sinopsis --}}
                <div>
                    <x-label for="description" value="Sinopsis" />
                    <x-textarea id="description" name="description" rows="5" required>{{ old('description') }}</x-textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                {{-- Géneros (Checkboxes) --}}
                <div>
                    <x-label value="Géneros" class="mb-3" />
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach($genres as $genre)
                            <label class="flex items-center space-x-3 p-3 bg-[#16181c] border border-gray-700 rounded-xl hover:border-yellow-400/50 cursor-pointer transition-colors">
                                <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                       class="rounded bg-gray-800 border-gray-600 text-yellow-400 focus:ring-yellow-400 focus:ring-offset-gray-900"
                                    {{ in_array($genre->id, old('genres', [])) ? 'checked' : '' }}>
                                <span class="text-gray-300 text-sm font-bold">{{ $genre->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('genres')" class="mt-2" />
                </div>

                {{-- Poster --}}
                <div>
                    <x-label for="poster" value="Póster (Imagen)" />
                    <x-input id="poster" type="file" name="poster" class="py-2" />
                    <x-input-error :messages="$errors->get('poster')" class="mt-2" />
                </div>

                {{-- Botones --}}
                <div class="flex justify-end gap-4 pt-4 border-t border-white/5">
                    <a href="{{ route('movies.index') }}" class="px-6 py-3 bg-gray-800 text-gray-300 font-bold rounded-xl hover:bg-gray-700 transition-colors">
                        Cancelar
                    </a>
                    <x-button>
                        Guardar Película
                    </x-button>
                </div>
            </form>
        </div>
    </div>
@endsection
