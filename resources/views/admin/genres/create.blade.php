@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-white font-['Outfit']">Crear Nuevo <span class="text-yellow-400">Género</span></h1>
            <a href="{{ route('admin.genres.index') }}" class="text-gray-400 hover:text-white transition-colors">
                &larr; Volver a la lista
            </a>
        </div>

        <div class="bg-[#0f1115] border border-white/5 rounded-xl p-8 shadow-xl max-w-2xl mx-auto">
            <form method="POST" action="{{ route('admin.genres.store') }}" class="space-y-6">
                @csrf

                {{-- Campo Nombre --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nombre del Género</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Ej. Ciencia Ficción"
                           class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all placeholder-gray-600"
                           required>
                    @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Campo Descripción --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Descripción (Opcional)</label>
                    <textarea name="description" rows="4" placeholder="Breve descripción de este género..."
                              class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all placeholder-gray-600 resize-none">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Botones de Acción --}}
                <div class="flex justify-end gap-4 pt-4 border-t border-white/5">
                    <a href="{{ route('admin.genres.index') }}" class="px-6 py-3 bg-gray-800 text-gray-300 font-bold rounded-xl hover:bg-gray-700 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-3 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-300 transition-colors shadow-[0_0_15px_rgba(250,204,21,0.4)]">
                        Guardar Género
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
