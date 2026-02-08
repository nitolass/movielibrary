@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-8">
        {{-- Encabezado --}}
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-white font-['Outfit']">
                {{ __('Nueva') }} <span class="text-yellow-400">{{ __('Película') }}</span>
            </h1>
            <a href="{{ route('movies.index') }}" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                {{ __('Volver al catálogo') }}
            </a>
        </div>

        <div class="bg-[#0f1115] border border-white/5 rounded-2xl p-8 shadow-2xl max-w-4xl mx-auto">
            <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                {{-- SECCIÓN 1: TÍTULO --}}
                <div class="border-b border-white/5 pb-6">
                    <x-label for="title" :value="__('Título de la Película')" class="text-lg mb-2 block" />
                    <x-input id="title" type="text" name="title" :value="old('title')" required
                             placeholder="{{ __('Ej: La Trampa') }}" class="w-full text-lg py-3" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                {{-- SECCIÓN 2: DATOS TÉCNICOS (Grid de 3 columnas) --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

                    {{-- Año (Ocupa 3 columnas) --}}
                    <div class="md:col-span-3">
                        <x-label for="year" :value="__('Año')" />
                        <div class="relative mt-1">
                            <x-input id="year" type="number" name="year" :value="old('year')" required placeholder="2024" class="w-full" />
                            <span class="absolute right-3 top-3 text-gray-500 text-sm">📅</span>
                        </div>
                        <x-input-error :messages="$errors->get('year')" class="mt-2" />
                    </div>

                    {{-- Duración (Ocupa 3 columnas) --}}
                    <div class="md:col-span-3">
                        <x-label for="duration" :value="__('Duración')" />
                        <div class="relative mt-1">
                            <x-input id="duration" type="number" name="duration" :value="old('duration')" required placeholder="120" class="w-full" />
                            <span class="absolute right-3 top-3 text-gray-500 text-sm">min</span>
                        </div>
                        <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                    </div>

                    {{-- Director (Ocupa 6 columnas - El resto del espacio) --}}
                    <div class="md:col-span-6">
                        <x-label for="director_id" :value="__('Director')" />
                        <div class="mt-1">
                            <x-select name="director_id" id="director_id" required class="w-full">
                                <option value="" disabled selected>{{ __('Selecciona un director...') }}</option>
                                @foreach($directors as $director)
                                    <option value="{{ $director->id }}" {{ old('director_id') == $director->id ? 'selected' : '' }}>
                                        {{ $director->name }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                        <x-input-error :messages="$errors->get('director_id')" class="mt-2" />
                    </div>
                </div>

                {{-- SECCIÓN 3: GÉNEROS (Componente Checkbox en Grid) --}}
                <div class="bg-[#16181c] p-6 rounded-xl border border-white/5">
                    <x-label :value="__('Géneros')" class="mb-4 text-yellow-400 font-bold uppercase tracking-wide text-xs" />

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($genres as $genre)
                            <label class="relative flex items-center p-3 rounded-lg border border-gray-700 cursor-pointer hover:bg-gray-800 hover:border-yellow-400/50 transition-all group">
                                <x-checkbox
                                    name="genres[]"
                                    value="{{ $genre->id }}"
                                    :checked="in_array($genre->id, old('genres', []))"
                                    class="text-yellow-400 bg-gray-900 border-gray-600 focus:ring-yellow-400 rounded"
                                />
                                <span class="ml-3 text-sm text-gray-300 group-hover:text-white font-medium select-none">
                                    {{ $genre->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('genres')" class="mt-2" />
                </div>

                {{-- SECCIÓN 4: DETALLES FINALES --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Sinopsis --}}
                    <div>
                        <x-label for="description" :value="__('Sinopsis')" />
                        <textarea id="description" name="description" rows="6" required
                                  class="mt-1 w-full rounded-xl bg-[#16181c] border-gray-700 text-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400"
                                  placeholder="{{ __('Escribe un breve resumen de la trama...') }}"
                        >{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    {{-- Póster --}}
                    <div>
                        <x-label for="poster" :value="__('Póster Oficial')" />
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-700 border-dashed rounded-xl hover:border-yellow-400/50 transition-colors bg-[#16181c]">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 005.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-400 justify-center">
                                    <label for="poster" class="relative cursor-pointer rounded-md font-medium text-yellow-400 hover:text-yellow-300 focus-within:outline-none">
                                        <span>{{ __('Subir un archivo') }}</span>
                                        <x-input id="poster" type="file" name="poster" class="sr-only" />
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">{{ __('PNG, JPG, GIF hasta 2MB') }}</p>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('poster')" class="mt-2" />
                    </div>
                </div>

                {{-- BOTONES DE ACCIÓN --}}
                <div class="flex justify-end gap-4 pt-6 border-t border-white/5">
                    <a href="{{ route('movies.index') }}" class="px-6 py-3 bg-transparent border border-gray-600 text-gray-300 font-bold rounded-xl hover:bg-gray-800 transition-colors">
                        {{ __('Cancelar') }}
                    </a>
                    <button type="submit" class="px-8 py-3 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-500 transform hover:scale-105 transition-all shadow-lg shadow-yellow-400/20">
                        {{ __('Guardar Película') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
