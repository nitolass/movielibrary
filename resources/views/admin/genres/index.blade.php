@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            {{-- "Gestión de" y "Géneros" ya están en el JSON --}}
            <h1 class="text-3xl font-bold text-white font-['Outfit']">{{ __('Gestión de') }} <span class="text-yellow-400">{{ __('Géneros') }}</span></h1>
            <a href="{{ route('admin.genres.create') }}" class="px-5 py-2.5 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-300 shadow-[0_0_15px_rgba(250,204,21,0.4)] transition-all">
                + {{ __('Nuevo') }} {{ __('Género') }}
            </a>
        </div>

        <div class="bg-[#0f1115] border border-white/5 rounded-xl overflow-hidden shadow-xl">
            <table class="min-w-full leading-normal text-left">
                <thead>
                <tr class="bg-white/5 text-gray-400 uppercase text-xs font-bold tracking-wider border-b border-white/5">
                    <th class="py-4 px-6">ID</th>
                    <th class="py-4 px-6">{{ __('Nombre') }}</th>
                    <th class="py-4 px-6">{{ __('Descripción') }}</th>
                    <th class="py-4 px-6 text-center">{{ __('Acciones') }}</th>
                </tr>
                </thead>
                <tbody class="text-gray-300 text-sm">
                @foreach($genres as $genre)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                        <td class="py-4 px-6 font-mono text-xs text-gray-500">{{ $genre->id }}</td>
                        <td class="py-4 px-6 font-bold text-white">{{ $genre->name }}</td>
                        <td class="py-4 px-6 text-gray-400">{{ Str::limit($genre->description, 50) }}</td>
                        <td class="py-4 px-6 flex justify-center gap-2">
                            {{-- Botón Editar --}}
                            <a href="{{ route('admin.genres.edit', $genre) }}" class="p-2 bg-gray-800 text-blue-400 rounded-lg hover:bg-blue-600 hover:text-white transition-all" title="{{ __('Editar') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>

                            {{-- Botón Eliminar --}}
                            <form action="{{ route('admin.genres.destroy', $genre) }}" method="POST" onsubmit="return confirm('{{ __('¿Estás seguro de eliminar?') }} {{ $genre->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-gray-800 text-red-400 rounded-lg hover:bg-red-600 hover:text-white transition-all" title="{{ __('Eliminar') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{-- Mensaje si no hay registros --}}
            @if($genres->isEmpty())
                <div class="p-8 text-center text-gray-500">
                    <p>{{ __('No hay géneros registrados aún.') }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection
