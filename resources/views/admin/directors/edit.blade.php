@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-white mb-6">Editar Director</h1>

        <form action="{{ route('directors.update', $director->id) }}" method="POST" enctype="multipart/form-data" class="bg-[#0f1115] p-8 rounded-xl border border-white/5 space-y-6 max-w-2xl mx-auto">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nombre</label>
                <input type="text" name="name" class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 outline-none focus:border-yellow-400" value="{{ old('name', $director->name) }}">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Biografía</label>
                {{-- OJO: Verifica si en tu BD es 'bio' o 'biography'. Usaré 'biography' por estándar, cámbialo si falla --}}
                <textarea name="biography" class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 outline-none focus:border-yellow-400" rows="4">{{ old('biography', $director->biography ?? $director->bio) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Año Nacimiento</label>
                    <input type="number" name="birth_year" class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 outline-none focus:border-yellow-400" value="{{ old('birth_year', $director->birth_year) }}">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nacionalidad</label>
                    <input type="text" name="nationality" class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 outline-none focus:border-yellow-400" value="{{ old('nationality', $director->nationality) }}">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Foto</label>
                <input type="file" name="photo" class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3">
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-8 py-3 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-300">Actualizar</button>
            </div>
        </form>
    </div>
@endsection
