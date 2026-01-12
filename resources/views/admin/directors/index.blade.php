@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Directores</h1>

        <a href="{{ route('directors.create') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 mb-4 inline-block">Crear Director</a>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
            <tr>
                <th class="border px-2 py-1">ID</th>
                <th class="border px-2 py-1">Nombre</th>
                <th class="border px-2 py-1">Nacionalidad</th>
                <th class="border px-2 py-1">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($directors as $director)
                <tr>
                    <td class="border px-2 py-1">{{ $director->id }}</td>
                    <td class="border px-2 py-1">{{ $director->name }}</td>
                    <td class="border px-2 py-1">{{ $director->nationality }}</td>
                    <td class="border px-2 py-1 flex gap-2">
                        <a href="{{ route('directors.edit', $director->id) }}" class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Editar</a>
                        <form action="{{ route('directors.destroy', $director->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este director?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
