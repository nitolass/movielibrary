@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Editar Actor</h1>

        <form action="{{ route('actors.update', $actor) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $actor->name) }}" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Biografía</label>
                <textarea name="biography" class="w-full border px-3 py-2 rounded" required>{{ old('biography', $actor->biography) }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Año de nacimiento</label>
                <input type="number" name="birth_year" value="{{ old('birth_year', $actor->birth_year) }}" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Nacionalidad</label>
                <input type="text" name="nationality" value="{{ old('nationality', $actor->nationality) }}" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Foto</label>
                <input type="file" name="photo" class="w-full border px-3 py-2 rounded" accept="image/*">
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Actualizar</button>
        </form>
    </div>
@endsection
