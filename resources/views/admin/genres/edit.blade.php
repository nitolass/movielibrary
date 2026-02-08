@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-white font-['Outfit']">{{ __('Editar') }} <span class="text-yellow-400">{{ __('Género') }}</span></h1>
            <a href="{{ route('admin.genres.index') }}" class="text-gray-400 hover:text-white transition-colors">&larr; {{ __('Volver') }}</a>
        </div>

        <div class="bg-[#0f1115] border border-white/5 rounded-xl p-8 shadow-xl max-w-xl mx-auto">
            <form action="{{ route('admin.genres.update', $genre) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <x-label for="name" :value="__('Nombre')" />
                    <x-input id="name" type="text" name="name" :value="old('name', $genre->name)" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-label for="description" :value="__('Descripción')" />
                    <x-textarea id="description" name="description" rows="3">{{ old('description', $genre->description) }}</x-textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-white/5">
                    <a href="{{ route('admin.genres.index') }}" class="px-6 py-3 bg-gray-800 text-gray-300 font-bold rounded-xl hover:bg-gray-700 transition-colors">{{ __('Cancelar') }}</a>
                    <x-button>{{ __('Actualizar') }}</x-button>
                </div>
            </form>
        </div>
    </div>
@endsection
