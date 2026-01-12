@extends('layouts.panel')

@section('content')
    <div class="max-w-5xl mx-auto">

        <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-black text-white font-['Outfit']">
                    Crear <span class="text-yellow-400">Película</span>
                </h1>
                <p class="text-gray-400 text-sm mt-1">Añade un nuevo título a tu biblioteca.</p>
            </div>
            <a href="{{ route('movies.index') }}" class="px-5 py-2.5 bg-gray-800 text-gray-300 font-bold rounded-xl hover:bg-gray-700 hover:text-white border border-white/5 transition-all text-sm">
                ← Volver al catálogo
            </a>
        </div>

        <div class="bg-[#0f1115] border border-white/5 rounded-3xl p-8 shadow-2xl relative overflow-hidden">

            <div class="absolute top-0 right-0 w-64 h-64 bg-yellow-400/5 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>

            <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 relative z-10">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

                    <div class="md:col-span-8 space-y-6">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Título Original</label>
                                <input type="text" name="title" value="{{ old('title') }}" placeholder="Ej. Interstellar"
                                       class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all placeholder-gray-600">
                                @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Año</label>
                                <input type="number" name="year" value="{{ old('year') }}" placeholder="2014"
                                       class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all placeholder-gray-600">
                                @error('year') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Duración (min)</label>
                                <input type="number" name="duration" value="{{ old('duration') }}" placeholder="169"
                                       class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Edad (Rating)</label>
                                <input type="number" name="age_rating" value="{{ old('age_rating') }}" placeholder="+12"
                                       class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all">
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">País</label>
                                <input type="text" name="country" value="{{ old('country') }}" placeholder="EE.UU."
                                       class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Sinopsis / Descripción</label>
                            <textarea name="description" rows="4" placeholder="Escribe un breve resumen de la trama..."
                                      class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all placeholder-gray-600 resize-none">{{ old('description') }}</textarea>
                        </div>

                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Póster Oficial</label>
                        <div class="relative w-full aspect-[2/3] border-2 border-dashed border-gray-700 rounded-2xl bg-[#16181c] hover:border-yellow-400/50 transition-colors overflow-hidden group">

                            <input type="file" name="poster" id="poster" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" onchange="previewImage(event)">

                            <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-4 z-10 pointer-events-none" id="upload-placeholder">
                                <svg class="w-10 h-10 text-gray-600 mb-3 group-hover:text-yellow-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm text-gray-400 font-bold">Subir Imagen</p>
                                <p class="text-xs text-gray-600 mt-1">JPG, PNG (Max 2MB)</p>
                            </div>

                            <img id="image-preview" src="#" class="hidden absolute inset-0 w-full h-full object-cover z-0">
                        </div>
                        @error('poster') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <hr class="border-white/5">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="space-y-6">

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Director</label>
                            <div class="relative">
                                <select name="director_id" class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 focus:border-yellow-400 outline-none appearance-none cursor-pointer">
                                    <option value="" disabled selected>Selecciona un director</option>
                                    @foreach($directors as $director)
                                        <option value="{{ $director->id }}" {{ old('director_id') == $director->id ? 'selected' : '' }}>
                                            {{ $director->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Actores (Mantén Ctrl para seleccionar varios)</label>
                            <select name="actors[]" multiple class="w-full h-32 bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-2 focus:border-yellow-400 outline-none custom-scrollbar">
                                @foreach($actors as $actor)
                                    <option value="{{ $actor->id }}" class="py-1 px-2 rounded hover:bg-yellow-400 hover:text-black cursor-pointer">
                                        {{ $actor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Géneros</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-4 bg-[#16181c] border border-gray-700 rounded-xl max-h-60 overflow-y-auto custom-scrollbar">
                            @foreach($genres as $genre)
                                <label class="cursor-pointer relative group">
                                    <input type="checkbox" name="genres[]" value="{{ $genre->id }}" class="peer sr-only">
                                    <div class="px-3 py-2 rounded-lg border border-gray-600 text-gray-400 text-xs font-bold text-center transition-all
                                            peer-checked:bg-yellow-400 peer-checked:text-black peer-checked:border-yellow-400
                                            group-hover:border-gray-400">
                                        {{ $genre->name }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="pt-6 border-t border-white/5 flex justify-end">
                    <button type="submit" class="px-8 py-4 bg-yellow-400 text-black font-black rounded-xl hover:bg-yellow-300 hover:shadow-[0_0_25px_rgba(250,204,21,0.5)] hover:-translate-y-1 transition-all uppercase tracking-widest text-sm flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Publicar Película
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('image-preview');
                const placeholder = document.getElementById('upload-placeholder');
                output.src = reader.result;
                output.classList.remove('hidden');
                placeholder.classList.add('opacity-0');
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
