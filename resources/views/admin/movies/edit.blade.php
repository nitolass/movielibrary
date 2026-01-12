@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold mb-6">Editar Película</h1>

        <form action="{{ route('movies.update', $movie) }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-gray-800 p-6 rounded text-white">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1">Título</label>
                <input type="text" name="title" class="w-full p-2 rounded bg-gray-700 text-white" value="{{ old('title', $movie->title) }}">
            </div>

            <div>
                <label class="block mb-1">Año</label>
                <input type="text" name="year" class="w-full p-2 rounded bg-gray-700 text-white" value="{{ old('year', $movie->year) }}">
            </div>

            <div>
                <label class="block mb-1">Descripción</label>
                <textarea name="description" class="w-full p-2 rounded bg-gray-700 text-white">{{ old('description', $movie->description) }}</textarea>
            </div>

            <div>
                <label class="block mb-1">Duración (min)</label>
                <input type="number" name="duration" class="w-full p-2 rounded bg-gray-700 text-white" value="{{ old('duration', $movie->duration) }}">
            </div>

            <div>
                <label class="block mb-1">Age Rating</label>
                <input type="number" name="age_rating" class="w-full p-2 rounded bg-gray-700 text-white" value="{{ old('age_rating', $movie->age_rating) }}">
            </div>

            <div>
                <label class="block mb-1">País</label>
                <input type="text" name="country" class="w-full p-2 rounded bg-gray-700 text-white" value="{{ old('country', $movie->country) }}">
            </div>

            <div>
                <label class="block mb-1">Poster</label>
                <input type="file" name="poster" class="w-full p-2 rounded bg-gray-700 text-white">
                @if($movie->poster)
                    <p class="mt-1">Poster actual: <img src="{{ asset('storage/'.$movie->poster) }}" alt="Poster" class="h-20"></p>
                @endif
            </div>

            <div>
                <label class="block mb-1">Géneros</label>
                <select name="genres[]" multiple class="w-full p-2 rounded bg-gray-700 text-white">
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ in_array($genre->id, $movie->genres->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $genre->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1">Directores</label>
                <select name="directors[]" multiple class="w-full p-2 rounded bg-gray-700 text-white">
                    @foreach($directors as $director)
                        <option value="{{ $director->id }}" {{ in_array($director->id, $movie->directors->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $director->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1">Actores</label>
                <select name="actors[]" multiple class="w-full p-2 rounded bg-gray-700 text-white">
                    @foreach($actors as $actor)
                        <option value="{{ $actor->id }}" {{ in_array($actor->id, $movie->actors->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $actor->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 rounded">Actualizar</button>
            </div>
        </form>
    </div>
@endsection
