@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Detalle del Actor</h1>

        <div class="bg-white shadow rounded p-6">
            <div class="mb-4">
                <strong>Nombre:</strong> {{ $actor->name }}
            </div>
            <div class="mb-4">
                <strong>Biografía:</strong>
                <p>{{ $actor->biography }}</p>
            </div>
            <div class="mb-4">
                <strong>Año de nacimiento:</strong> {{ $actor->birth_year }}
            </div>
            <div class="mb-4">
                <strong>Nacionalidad:</strong> {{ $actor->nationality }}
            </div>
            @if($actor->photo)
                <div class="mb-4">
                    <strong>Foto:</strong>
                    <img src="{{ asset('storage/'.$actor->photo) }}" alt="{{ $actor->name }}" class="w-48 h-auto rounded mt-2">
                </div>
            @endif

            <a href="{{ route('actors.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Volver</a>
        </div>
    </div>
@endsection
