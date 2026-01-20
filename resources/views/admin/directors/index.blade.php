@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white font-['Outfit']">Directores</h1>
            <a href="{{ route('directors.create') }}" class="px-5 py-2.5 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-300 shadow-[0_0_15px_rgba(250,204,21,0.4)] transition-all">
                + Crear Director
            </a>
        </div>

        <div class="bg-[#0f1115] border border-white/5 rounded-xl overflow-hidden shadow-xl">
            <table class="min-w-full leading-normal text-left">
                <thead>
                <tr class="bg-white/5 text-gray-400 uppercase text-xs font-bold tracking-wider border-b border-white/5">
                    <th class="py-4 px-6">ID</th>
                    <th class="py-4 px-6">Nombre</th>
                    <th class="py-4 px-6">Nacionalidad</th>
                    <th class="py-4 px-6 text-center">Acciones</th>
                </tr>
                </thead>
                <tbody class="text-gray-300 text-sm">
                @foreach($directors as $director)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                        <td class="py-4 px-6 font-mono text-xs text-gray-500">{{ $director->id }}</td>
                        <td class="py-4 px-6 font-bold text-white">{{ $director->name }}</td>
                        <td class="py-4 px-6">{{ $director->nationality }}</td>
                        <td class="py-4 px-6 flex justify-center gap-2">
                            <a href="{{ route('directors.edit', $director->id) }}" class="p-2 bg-gray-800 text-blue-400 rounded-lg hover:bg-blue-600 hover:text-white transition-all">Editar</a>
                            <form action="{{ route('directors.destroy', $director->id) }}" method="POST" onsubmit="return confirm('¿Eliminar director?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-gray-800 text-red-400 rounded-lg hover:bg-red-600 hover:text-white transition-all">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
