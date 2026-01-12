@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold mb-6">Películas</h1>

        <a href="{{ route('movies.create') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded mb-4 inline-block">Crear Película</a>

        <table class="min-w-full bg-gray-800 text-white rounded">
            <thead>
            <tr class="border-b border-gray-700">
                <th class="px-4 py-2 text-left">Título</th>
                <th class="px-4 py-2">Año</th>
                <th class="px-4 py-2">Géneros</th>
                <th class="px-4 py-2">Directores</th>
                <th class="px-4 py-2">Actores</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($movies as $movie)
                <tr class="border-b border-gray-700">
                    <td class="px-4 py-2">{{ $movie->title }}</td>
                    <td class="px-4 py-2">{{ $movie->year }}</td>
                    <td class="px-4 py-2">
                        {{ $movie->genres->pluck('name')->join(', ') }}
                    </td>
                    <td class="px-4 py-2">
                        {{ $movie->directors->pluck('name')->join(', ') }}
                    </td>
                    <td class="px-4 py-2">
                        {{ $movie->actors->pluck('name')->join(', ') }}
                    </td>
                    <td class="px-4 py-2 flex gap-2">
                        <a href="{{ route('movies.show', $movie) }}" class="px-2 py-1 bg-blue-600 rounded hover:bg-blue-700">Ver</a>
                        <a href="{{ route('movies.edit', $movie) }}" class="px-2 py-1 bg-yellow-600 rounded hover:bg-yellow-700">Editar</a>
                        <form action="{{ route('movies.destroy', $movie) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 py-1 bg-red-600 rounded hover:bg-red-700">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
