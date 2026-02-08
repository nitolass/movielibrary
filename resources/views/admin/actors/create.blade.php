@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-white font-['Outfit']">{{ __('Añadir') }} <span class="text-yellow-400">{{ __('Actor') }}</span></h1>
            <a href="{{ route('actors.index') }}" class="text-gray-400 hover:text-white transition-colors">
                &larr; {{ __('Volver') }}
            </a>
        </div>

        <div class="bg-[#0f1115] border border-white/5 rounded-xl p-8 shadow-xl max-w-2xl mx-auto">
            <form action="{{ route('actors.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- CAMPO: Nombre --}}
                <div>
                    <x-label for="name" :value="__('Nombre Completo')" />
                    <x-input id="name" type="text" name="name" :value="old('name')" required autofocus placeholder="Ej: Brad Pitt" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- CAMPO: Biografía --}}
                <div>
                    <x-label for="biography" :value="__('Biografía')" />
                    <x-textarea id="biography" name="biography" rows="4">{{ old('biography') }}</x-textarea>
                    <x-input-error :messages="$errors->get('biography')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- CAMPO: Año Nacimiento --}}
                    <div>
                        <x-label for="birth_year" :value="__('Año de Nacimiento')" />
                        <x-input id="birth_year" type="number" name="birth_year" :value="old('birth_year')" placeholder="Ej: 1980" />
                        <x-input-error :messages="$errors->get('birth_year')" class="mt-2" />
                    </div>

                    {{-- CAMPO: Nacionalidad --}}
                    <div>
                        <x-label for="nationality" :value="__('Nacionalidad')" />
                        <x-input id="nationality" type="text" name="nationality" :value="old('nationality')" placeholder="Ej: USA" />
                        <x-input-error :messages="$errors->get('nationality')" class="mt-2" />
                    </div>
                </div>

                {{-- CAMPO: Foto --}}
                <div>
                    <x-label for="photo" :value="__('Fotografía')" />
                    <x-input id="photo" type="file" name="photo" class="py-2" />
                    <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                </div>

                {{-- Botones --}}
                <div class="flex justify-end gap-4 pt-4 border-t border-white/5">
                    <a href="{{ route('actors.index') }}" class="px-6 py-3 bg-gray-800 text-gray-300 font-bold rounded-xl hover:bg-gray-700 transition-colors">
                        {{ __('Cancelar') }}
                    </a>

                    {{-- Botón Guardar --}}
                    <x-button>
                        {{ __('Guardar') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
@endsection
