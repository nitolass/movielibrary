@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Crear Director</h1>

        <form action="{{ route('directors.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block mb-1">Nombre</label>
                <input type="text" name="name" class="border rounded px-2 py-1 w-full" value="{{ old('name') }}">
            </div>

            <div>
                <label class="block mb-1">Biografía</label>
                <textarea name="bio" class="border rounded px-2 py-1 w-full">{{ old('bio') }}</textarea>
            </div>

            <div>
                <label class="block mb-1">Año de nacimiento</label>
                <input type="number" name="birth_year" class="border rounded px-2 py-1 w-full" value="{{ old('birth_year') }}">
            </div>

            <div>
                <label class="block mb-1">Nacionalidad</label>
                <input type="text" name="nationality" class="border rounded px-2 py-1 w-full" value="{{ old('nationality') }}">
            </div>

            <div>
                <label class="block mb-1">Foto</label>
                <input type="file" name="photo" class="border rounded px-2 py-1 w-full">
            </div>

            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Guardar</button>
        </form>
    </div>
@endsection
