@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-white font-['Outfit']">{{ __('Editar') }} <span class="text-yellow-400">{{ __('Director') }}</span></h1>
            <a href="{{ route('directors.index') }}" class="text-gray-400 hover:text-white transition-colors">&larr; {{ __('Volver') }}</a>
        </div>

        <div class="bg-[#0f1115] border border-white/5 rounded-xl p-8 shadow-xl max-w-2xl mx-auto">
            <form action="{{ route('directors.update', $director) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <x-label for="name" :value="__('Nombre')" />
                    <x-input id="name" type="text" name="name" :value="old('name', $director->name)" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-label for="biography" :value="__('Biografía')" />
                    <x-textarea id="biography" name="biography" rows="4">{{ old('biography', $director->biography ?? $director->bio) }}</x-textarea>
                    <x-input-error :messages="$errors->get('biography')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-label for="birth_year" :value="__('Año Nacimiento')" />
                        <x-input id="birth_year" type="number" name="birth_year" :value="old('birth_year', $director->birth_year)" />
                        <x-input-error :messages="$errors->get('birth_year')" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="nationality" :value="__('Nacionalidad')" />
                        <x-input id="nationality" type="text" name="nationality" :value="old('nationality', $director->nationality)" />
                        <x-input-error :messages="$errors->get('nationality')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-label for="photo" :value="__('Cambiar Foto (Opcional)')" />
                    @if($director->photo)
                        <img src="{{ asset('storage/' . $director->photo) }}" class="h-16 w-16 object-cover rounded-lg mb-2 border border-gray-700">
                    @endif
                    <x-input id="photo" type="file" name="photo" class="py-2" />
                    <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-white/5">
                    <a href="{{ route('directors.index') }}" class="px-6 py-3 bg-gray-800 text-gray-300 font-bold rounded-xl hover:bg-gray-700 transition-colors">{{ __('Cancelar') }}</a>
                    <x-button>{{ __('Actualizar') }}</x-button>
                </div>
            </form>
        </div>
    </div>
@endsection
