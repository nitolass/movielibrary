@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Actores</h1>
            <a href="{{ route('actors.create') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Crear Actor</a>
        </div>

        <table class="min-w-full bg-white shadow rounded">
            <thead>
            <tr class="bg-gray-200 text-left">
                <th class="py-2 px-4">Nombre</th>
                <th class="py-2 px-4">Año de Nacimiento</th>
                <th class="py-2 px-4">Nacionalidad</th>
                <th class="py-2 px-4">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($actors as $actor)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $actor->name }}</td>
                    <td class="py-2 px-4">{{ $actor->birth_year }}</td>
                    <td class="py-2 px-4">{{ $actor->nationality }}</td>
                    <td class="py-2 px-4 flex gap-2">
                        <a href="{{ route('actors.edit', $actor) }}" class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Editar</a>
                        <form action="{{ route('actors.destroy', $actor) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminarlo?');">
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
