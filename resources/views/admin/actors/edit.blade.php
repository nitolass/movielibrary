@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-white font-['Outfit']">Editar <span class="text-yellow-400">Actor</span></h1>
            <a href="{{ route('actors.index') }}" class="text-gray-400 hover:text-white transition-colors">
                &larr; Volver
            </a>
        </div>

        <div class="bg-[#0f1115] border border-white/5 rounded-xl p-8 shadow-xl max-w-2xl mx-auto">
            <form action="{{ route('actors.update', $actor) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div>
                    <x-label for="name" value="Nombre" />
                    <x-input id="name" type="text" name="name" :value="old('name', $actor->name)" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Biografía --}}
                <div>
                    <x-label for="biography" value="Biografía" />
                    <x-textarea id="biography" name="biography" rows="4">{{ old('biography', $actor->biography) }}</x-textarea>
                    <x-input-error :messages="$errors->get('biography')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Año --}}
                    <div>
                        <x-label for="birth_year" value="Año Nacimiento" />
                        <x-input id="birth_year" type="number" name="birth_year" :value="old('birth_year', $actor->birth_year)" />
                        <x-input-error :messages="$errors->get('birth_year')" class="mt-2" />
                    </div>

                    {{-- Nacionalidad --}}
                    <div>
                        <x-label for="nationality" value="Nacionalidad" />
                        <x-input id="nationality" type="text" name="nationality" :value="old('nationality', $actor->nationality)" />
                        <x-input-error :messages="$errors->get('nationality')" class="mt-2" />
                    </div>
                </div>

                {{-- Foto --}}
                <div>
                    <x-label for="photo" value="Cambiar Foto (Opcional)" />
                    @if($actor->photo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $actor->photo) }}" alt="Foto actual" class="h-16 w-16 object-cover rounded-lg border border-gray-700">
                        </div>
                    @endif
                    <x-input id="photo" type="file" name="photo" class="py-2" />
                    <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-white/5">
                    <a href="{{ route('actors.index') }}" class="px-6 py-3 bg-gray-800 text-gray-300 font-bold rounded-xl hover:bg-gray-700 transition-colors">Cancelar</a>
                    <x-button>Actualizar Actor</x-button>
                </div>
            </form>
        </div>
    </div>
@endsection
