@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold mb-6 text-white">Editar Película</h1>

        <form action="{{ route('movies.update', $movie) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-[#0f1115] p-8 rounded-3xl border border-white/5 text-white shadow-2xl">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Título --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Título</label>
                    <input type="text" name="title" class="w-full bg-[#16181c] border border-gray-700 rounded-xl px-4 py-3 focus:border-yellow-400 outline-none text-white" value="{{ old('title', $movie->title) }}">
                </div>

                {{-- Año --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Año</label>
                    <input type="text" name="year" class="w-full bg-[#16181c] border border-gray-700 rounded-xl px-4 py-3 focus:border-yellow-400 outline-none text-white" value="{{ old('year', $movie->year) }}">
                </div>
            </div>

            {{-- Descripción --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Descripción</label>
                <textarea name="description" rows="4" class="w-full bg-[#16181c] border border-gray-700 rounded-xl px-4 py-3 focus:border-yellow-400 outline-none text-white">{{ old('description', $movie->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Duración --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Duración (min)</label>
                    <input type="number" name="duration" class="w-full bg-[#16181c] border border-gray-700 rounded-xl px-4 py-3 focus:border-yellow-400 outline-none text-white" value="{{ old('duration', $movie->duration) }}">
                </div>

                {{-- Age Rating --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Edad</label>
                    <input type="number" name="age_rating" class="w-full bg-[#16181c] border border-gray-700 rounded-xl px-4 py-3 focus:border-yellow-400 outline-none text-white" value="{{ old('age_rating', $movie->age_rating) }}">
                </div>

                {{-- País --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">País</label>
                    <input type="text" name="country" class="w-full bg-[#16181c] border border-gray-700 rounded-xl px-4 py-3 focus:border-yellow-400 outline-none text-white" value="{{ old('country', $movie->country) }}">
                </div>
            </div>

            <hr class="border-white/10 my-4">

            {{-- CORRECCIÓN CRÍTICA: DIRECTOR (Single Select) --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Director</label>
                <select name="director_id" class="w-full bg-[#16181c] border border-gray-700 rounded-xl px-4 py-3 focus:border-yellow-400 outline-none text-white">
                    <option value="" disabled>Selecciona un director</option>
                    @foreach($directors as $director)
                        <option value="{{ $director->id }}" {{ old('director_id', $movie->director_id) == $director->id ? 'selected' : '' }}>
                            {{ $director->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Actores (Multiple) --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Actores (Ctrl + Click)</label>
                <select name="actors[]" multiple class="w-full h-32 bg-[#16181c] border border-gray-700 rounded-xl px-4 py-2 focus:border-yellow-400 outline-none text-white custom-scrollbar">
                    @foreach($actors as $actor)
                        <option value="{{ $actor->id }}" {{ in_array($actor->id, $movie->actors->pluck('id')->toArray()) ? 'selected' : '' }} class="p-2 hover:bg-yellow-400 hover:text-black rounded">
                            {{ $actor->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Géneros (Multiple) --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Géneros (Ctrl + Click)</label>
                <select name="genres[]" multiple class="w-full h-32 bg-[#16181c] border border-gray-700 rounded-xl px-4 py-2 focus:border-yellow-400 outline-none text-white custom-scrollbar">
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ in_array($genre->id, $movie->genres->pluck('id')->toArray()) ? 'selected' : '' }} class="p-2 hover:bg-yellow-400 hover:text-black rounded">
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Poster --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Poster Actual</label>
                @if($movie->poster)
                    <img src="{{ asset('storage/'.$movie->poster) }}" alt="Poster" class="h-32 rounded-lg mb-4 border border-white/10">
                @endif
                <input type="file" name="poster" class="w-full bg-[#16181c] border border-gray-700 rounded-xl px-4 py-3 text-white">
            </div>

            <div class="pt-4">
                <button type="submit" class="px-8 py-3 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-300 transition-colors">
                    Actualizar Película
                </button>
                <a href="{{ route('movies.index') }}" class="ml-4 text-gray-400 hover:text-white transition-colors">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
