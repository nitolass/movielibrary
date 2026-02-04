<div class="min-h-screen bg-[#0f1115]">

    {{-- 1. IMPORTAMOS LA SIDEBAR --}}
    @include('layouts.sidebar_client')

    {{-- 2. CONTENIDO PRINCIPAL (Con margen a la izquierda) --}}
    <div class="md:ml-64 p-8 pt-24 text-white">

        <div class="flex items-center gap-3 mb-8">
            <h1 class="text-3xl font-black">Mis Reseñas <span class="text-yellow-400">.</span></h1>
            <span class="text-gray-500 text-sm mt-2">Gestiona tus opiniones aquí.</span>
        </div>

        {{-- Mensaje de éxito --}}
        @if (session()->has('message'))
            <div class="bg-green-500/10 border border-green-500 text-green-400 p-4 rounded-xl mb-6 flex items-center gap-2">
                <span>✅</span> {{ session('message') }}
            </div>
        @endif

        {{-- FORMULARIO DE EDICIÓN (Solo aparece al editar) --}}
        @if($isEditing)
            <div class="bg-[#16181c] border border-yellow-500/50 p-6 rounded-2xl mb-8 shadow-[0_0_20px_rgba(250,204,21,0.1)] max-w-2xl">
                <h3 class="text-xl font-bold text-yellow-400 mb-4">Editar Reseña</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-400 text-sm font-bold mb-2">Puntuación</label>
                        <select wire:model="rating" class="w-full bg-[#0f1115] text-white border border-gray-700 rounded-xl p-3 focus:border-yellow-400 outline-none">
                            <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                            <option value="4">⭐⭐⭐⭐ (4)</option>
                            <option value="3">⭐⭐⭐ (3)</option>
                            <option value="2">⭐⭐ (2)</option>
                            <option value="1">⭐ (1)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-400 text-sm font-bold mb-2">Tu opinión</label>
                        <textarea wire:model="content" rows="3" class="w-full bg-[#0f1115] text-white border border-gray-700 rounded-xl p-3 focus:border-yellow-400 outline-none"></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button wire:click="cancel" class="px-4 py-2 bg-gray-700 rounded-xl hover:bg-gray-600">Cancelar</button>
                        <button wire:click="update" class="px-4 py-2 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-500">Guardar</button>
                    </div>
                </div>
            </div>
        @endif

        {{-- GRID DE RESEÑAS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($reviews as $review)
                <div class="bg-[#16181c] border border-white/5 p-5 rounded-2xl hover:border-yellow-400/30 transition flex flex-col h-full group">
                    {{-- Cabecera con Foto --}}
                    <div class="flex gap-4 mb-4">
                        <div class="shrink-0">
                            @if($review->movie && $review->movie->poster)
                                <a href="{{ route('user.movies.show', $review->movie->id) }}">
                                    <img src="{{ asset('storage/' . $review->movie->poster) }}" alt="" class="w-16 h-24 object-cover rounded-lg shadow-md">
                                </a>
                            @else
                                <div class="w-16 h-24 bg-gray-800 rounded-lg flex items-center justify-center text-xs text-gray-500">Sin img</div>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-white group-hover:text-yellow-400 transition line-clamp-2">
                                {{ $review->movie->title ?? 'Película borrada' }}
                            </h3>
                            <div class="text-yellow-400 text-sm mt-1">
                                @for($i=0; $i < $review->rating; $i++) ★ @endfor
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    {{-- Texto --}}
                    <div class="flex-1 bg-[#0f1115] p-3 rounded-xl mb-4 border border-white/5">
                        <p class="text-gray-300 text-sm italic">"{{ Str::limit($review->content, 100) }}"</p>
                    </div>

                    {{-- Botones --}}
                    <div class="flex justify-end gap-3 mt-auto pt-3 border-t border-white/5">
                        <a href="{{ route('reviews.edit', $review->id) }}" class="text-sm font-bold text-gray-400 hover:text-white flex items-center gap-1 bg-white/5 px-3 py-1.5 rounded-lg transition-colors">
                            ✏️ Editar
                        </a>
                        <button wire:click="delete({{ $review->id }})" wire:confirm="¿Borrar?" class="text-sm font-bold text-red-400 hover:text-red-300 flex items-center gap-1">
                            🗑️ Borrar
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center border border-dashed border-gray-700 rounded-3xl">
                    <p class="text-gray-400 text-lg mb-4">Aún no has escrito ninguna reseña.</p>
                    <a href="{{ route('user.movies.index') }}" class="px-6 py-2 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-500">
                        Ir al Catálogo
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
