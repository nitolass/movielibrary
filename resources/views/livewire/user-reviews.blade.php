<div> {{-- DIV RAÍZ OBLIGATORIO --}}
    <div class="container mx-auto px-4 py-8">

        {{-- BOTÓN VOLVER --}}
        <div class="mb-6">
            <a href="{{ route('user.movies.index') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-yellow-400 transition-colors text-sm font-medium group">
                <div class="bg-white/5 p-1.5 rounded-lg group-hover:bg-yellow-400/10 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </div>
                <span>Volver al Catálogo</span>
            </a>
        </div>

        {{-- CABECERA --}}
        <div class="flex items-center gap-3 mb-8">
            <h1 class="text-3xl font-black text-white font-['Outfit']">Mis Reseñas <span class="text-yellow-400">.</span></h1>
            <span class="text-gray-500 text-sm mt-2">Gestiona tus opiniones aquí.</span>
        </div>

        {{-- MENSAJE DE ÉXITO --}}
        @if (session()->has('message'))
            <div class="bg-green-500/10 border border-green-500 text-green-400 p-4 rounded-xl mb-6 flex items-center gap-2">
                <span>✅</span> {{ session('message') }}
            </div>
        @endif

        {{-- FORMULARIO DE EDICIÓN (Solo aparece al editar) --}}
        @if($isEditing)
            <div class="bg-[#16181c] border border-yellow-500/50 p-6 rounded-2xl mb-8 shadow-[0_0_20px_rgba(250,204,21,0.1)] max-w-2xl mx-auto">
                <h3 class="text-xl font-bold text-yellow-400 mb-4">Editar Reseña</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-400 text-sm font-bold mb-2">Puntuación</label>
                        <select wire:model="rating" class="w-full bg-[#0f1115] text-white border border-gray-700 rounded-xl p-3 focus:border-yellow-400 outline-none transition-colors">
                            <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                            <option value="4">⭐⭐⭐⭐ (4)</option>
                            <option value="3">⭐⭐⭐ (3)</option>
                            <option value="2">⭐⭐ (2)</option>
                            <option value="1">⭐ (1)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-400 text-sm font-bold mb-2">Tu opinión</label>
                        <textarea wire:model="content" rows="3" class="w-full bg-[#0f1115] text-white border border-gray-700 rounded-xl p-3 focus:border-yellow-400 outline-none transition-colors"></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button wire:click="cancel" class="px-4 py-2 bg-gray-700 text-white rounded-xl hover:bg-gray-600 transition-colors">Cancelar</button>
                        <button wire:click="update" class="px-4 py-2 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-500 transition-colors shadow-lg shadow-yellow-400/20">Guardar</button>
                    </div>
                </div>
            </div>
        @endif

        {{-- GRID DE RESEÑAS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($reviews as $review)
                <div class="bg-[#16181c] border border-white/5 p-5 rounded-2xl hover:border-yellow-400/30 transition duration-300 flex flex-col h-full group hover:-translate-y-1 hover:shadow-xl">
                    {{-- Cabecera con Foto --}}
                    <div class="flex gap-4 mb-4">
                        <div class="shrink-0">
                            @if($review->movie && $review->movie->poster)
                                <a href="{{ route('user.movies.show', $review->movie->id) }}">
                                    <img src="{{ asset('storage/' . $review->movie->poster) }}" alt="" class="w-16 h-24 object-cover rounded-lg shadow-md group-hover:scale-105 transition-transform">
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
                        <button wire:click="edit({{ $review->id }})"
                                class="text-sm font-bold text-gray-400 hover:text-white flex items-center gap-1 bg-white/5 px-3 py-1.5 rounded-lg transition-colors hover:bg-white/10">
                            ✏️ Editar
                        </button>

                        <button wire:click="delete({{ $review->id }})"
                                wire:confirm="¿Estás seguro de que quieres borrar esta reseña?"
                                class="text-sm font-bold text-red-400 hover:text-red-300 flex items-center gap-1 px-2 py-1.5 transition-colors">
                            🗑️ Borrar
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center border border-dashed border-gray-700 rounded-3xl bg-[#16181c]/50">
                    <p class="text-gray-400 text-lg mb-4">Aún no has escrito ninguna reseña.</p>
                    <a href="{{ route('user.movies.index') }}" class="inline-block px-6 py-2 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-500 transition-colors shadow-lg shadow-yellow-400/20">
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
