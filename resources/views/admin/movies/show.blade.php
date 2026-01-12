@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6 text-white">
        <h1 class="text-3xl font-bold mb-4">{{ $movie->title }}</h1>
        <p><strong>Año:</strong> {{ $movie->year }}</p>
        <p><strong>Descripción:</strong> {{ $movie->description }}</p>
        <p><strong>Duración:</strong> {{ $movie->duration }} minutos</p>
        <p><strong>Age Rating:</strong> {{ $movie->age_rating }}</p>
        <p><strong>País:</strong> {{ $movie->country }}</p>
        <p><strong>Géneros:</strong> {{ $movie->genres->pluck('name')->join(', ') }}</p>
        <p><strong>Directores:</strong> {{ $movie->directors->pluck('name')->join(', ') }}</p>
        <p><strong>Actores:</strong> {{ $movie->actors->pluck('name')->join(', ') }}</p>

        @if($movie->poster)
            <p class="mt-4"><img src="{{ asset('storage/'.$movie->poster) }}" alt="Poster" class="h-48"></p>
        @endif

        <a href="{{ route('movies.index') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded">Volver</a>
    </div>
@endsection
