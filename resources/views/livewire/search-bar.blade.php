<div class="relative w-full max-w-md hidden md:block px-6">

    {{-- Input del Buscador --}}
    <div class="relative">
        <input
            wire:model.live.debounce.300ms="search"
            type="text"
            placeholder="Buscar título, año, director..."
            class="w-full bg-black/20 border border-white/10 rounded-full py-2 pl-10 pr-4 text-sm text-white placeholder-gray-400 focus:outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 transition-all"
        >

        {{-- Icono Lupa --}}
        <div class="absolute left-3 top-2.5 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    {{-- Lista de Resultados (Solo aparece si hay búsqueda) --}}
    @if(strlen($search) >= 2)
        <div class="absolute w-full mt-2 bg-[#1f2937] border border-white/10 rounded-xl shadow-2xl z-50 overflow-hidden">
            @forelse($results as $movie)
                {{-- Enlace a la ficha de la película --}}
                <a href="{{ route('user.movies.show', $movie->id) }}" class="flex items-center gap-3 p-3 hover:bg-yellow-400 hover:text-black transition-colors group border-b border-white/5 last:border-0">

                    {{-- Mini Poster --}}
                    @if($movie->poster)
                        <img src="{{ asset('storage/' . $movie->poster) }}" class="w-8 h-12 object-cover rounded shadow-sm" alt="{{ $movie->title }}">
                    @else
                        <div class="w-8 h-12 bg-gray-700 rounded flex items-center justify-center text-[10px] text-gray-400">Sin img</div>
                    @endif

                    {{-- Texto --}}
                    <div>
                        <p class="font-bold text-sm text-white group-hover:text-black">{{ $movie->title }}</p>
                        <p class="text-xs text-gray-400 group-hover:text-black/70">
                            {{ $movie->year }} • {{ $movie->director->name ?? 'Sin director' }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="p-4 text-center text-sm text-gray-400">
                    No hemos encontrado nada... 🕵️
                </div>
            @endforelse
        </div>
    @endif
</div>
