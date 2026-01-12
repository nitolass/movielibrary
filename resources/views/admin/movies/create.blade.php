@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold mb-6">Crear Película</h1>

        <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-gray-800 p-6 rounded text-white">
            @csrf

            <div>
                <label class="block mb-1">Título</label>
                <input type="text" name="title" class="w-full p-2 rounded bg-gray-700 text-white" value="{{ old('title') }}">
            </div>

            <div>
                <label class="block mb-1">Año</label>
                <input type="text" name="year" class="w-full p-2 rounded bg-gray-700 text-white" value="{{ old('year') }}">
            </div>

            <div>
                <label class="block mb-1">Descripción</label>
                <textarea name="description" class="w-full p-2 rounded bg-gray-700 text-white">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block mb-1">Duración (min)</label>
                <input type="number" name="duration" class="w-full p-2 rounded bg-gray-700 text-white" value="{{ old('duration') }}">
            </div>

            <div>
                <label class="block mb-1">Age Rating</label>
                <input type="number" name="age_rating" class="w-full p-2 rounded bg-gray-700 text-white" value="{{ old('age_rating') }}">
            </div>

            <div>
                <label class="block mb-1">País</label>
                <input type="text" name="country" class="w-full p-2 rounded bg-gray-700 text-white" value="{{ old('country') }}">
            </div>

            <div>
                <label class="block mb-1">Poster</label>
                <input type="file" name="poster" class="w-full p-2 rounded bg-gray-700 text-white">
            </div>

            <div>
                <label class="block mb-1">Géneros</label>
                <select name="genres[]" multiple class="w-full p-2 rounded bg-gray-700 text-white">
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1">Directores</label>
                <select name="directors[]" multiple class="w-full p-2 rounded bg-gray-700 text-white">
                    @foreach($directors as $director)
                        <option value="{{ $director->id }}">{{ $director->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1">Actores</label>
                <select name="actors[]" multiple class="w-full p-2 rounded bg-gray-700 text-white">
                    @foreach($actors as $actor)
                        <option value="{{ $actor->id }}">{{ $actor->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded">Crear</button>
            </div>
        </form>
    </div>
@endsection
