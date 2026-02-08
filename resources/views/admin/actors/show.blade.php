@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">{{ __('Detalles del Actor') }}</h1>

        <div class="bg-gray-800 p-4 rounded shadow space-y-4 text-white">
            <div>
                <strong>{{ __('Nombre') }}:</strong> {{ $actor->name }}
            </div>

            <div>
                <strong>{{ __('Biografía') }}:</strong>
                <p>{{ $actor->biography }}</p>
            </div>

            <div>
                <strong>{{ __('Año de nacimiento') }}:</strong> {{ $actor->birth_year }}
            </div>

            <div>
                <strong>{{ __('Nacionalidad') }}:</strong> {{ $actor->nationality }}
            </div>

            @if($actor->photo)
                <div>
                    <strong>{{ __('Foto') }}:</strong>
                    <img src="{{ asset('storage/' . $actor->photo) }}" alt="Foto" class="mt-2 w-48 h-48 object-cover rounded">
                </div>
            @endif
        </div>

        <div class="mt-4 flex gap-2">
            <a href="{{ route('actors.edit', $actor->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">{{ __('Editar') }}</a>
            <a href="{{ route('actors.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">{{ __('Volver') }}</a>
        </div>
    </div>
@endsection
