@extends('layouts.panel')

@section('title', 'Catálogo de Películas - ' . config('app.name'))

@section('content')
    <div class="container mx-auto px-6 py-8" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">

        {{-- ENCABEZADO Y BOTONES SUPERIORES --}}
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-6 transition-all duration-700 opacity-0 translate-y-4" :class="loaded ? 'opacity-100 translate-y-0' : ''">

            <div>
                <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight drop-shadow-lg font-['Outfit'] leading-tight">
                    Mi <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-yellow-200">Colección</span>
                </h1>
                <p class="text-gray-400 text-sm mt-3 font-medium max-w-md">Explora y gestiona todas las películas que has guardado.</p>
            </div>

            <div class="flex flex-wrap items-center gap-4 justify-end">



                <a href="{{ route('movies.create') }}" class="relative inline-flex items-center justify-center px-6 py-2.5 font-bold text-sm text-black transition-all duration-300 bg-gradient-to-r from-yellow-400 to-yellow-500 font-['Outfit'] rounded-xl hover:from-yellow-300 hover:to-yellow-400 hover:shadow-[0_0_25px_rgba(250,204,21,0.6)] hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 whitespace-nowrap overflow-hidden group">
                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-[150%] group-hover:translate-x-[150%] transition-transform duration-700 ease-in-out"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 -ml-1 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="relative z-10">Añadir Película</span>
                </a>
            </div>
        </div>

        {{-- GRID DE PELÍCULAS --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-y-10 gap-x-6 transition-all duration-700 delay-300 opacity-0 translate-y-8" :class="loaded ? 'opacity-100 translate-y-0' : ''">

            @forelse($movies as $movie)
                <div class="group flex flex-col h-full relative">

                    <div class="relative w-full aspect-[2/3] rounded-2xl overflow-hidden bg-gray-900/50 border border-white/5 shadow-lg group-hover:shadow-[0_0_40px_rgba(0,0,0,0.6)] group-hover:border-yellow-500/50 transition-all duration-500 mb-4 z-0 group-hover:z-10">

                        {{-- 2. CORRECCIÓN DE IMAGEN: Usamos $movie->poster en vez de $movie->image --}}
                        @if($movie->poster)
                            <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out will-change-transform">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-gray-800 to-gray-900 group-hover:from-gray-700 group-hover:to-gray-800 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-600 opacity-40 group-hover:opacity-60 group-hover:text-yellow-400 transition-all duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-gray-500 text-xs mt-2 font-medium opacity-0 group-hover:opacity-100 transition-opacity">Sin póster</span>
                            </div>
                        @endif

                        {{-- PUNTUACIÓN (Si existe) --}}
                        @if(isset($movie->score))
                            <div class="absolute top-3 right-3 h-11 w-11 flex items-center justify-center rounded-full bg-gray-900/60 border-2 border-yellow-400 backdrop-blur-md shadow-[0_0_15px_rgba(250,204,21,0.3)] z-10 group-hover:scale-105 transition-transform">
                                <span class="text-yellow-400 text-sm font-black">{{ number_format($movie->score, 1) }}</span>
                            </div>
                        @endif

                        {{-- OVERLAY DE ACCIONES --}}
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center items-center gap-3 p-6 backdrop-blur-[2px] z-20">

                            <a href="{{ route('movies.show', $movie) }}" class="w-full py-3.5 bg-gradient-to-r from-yellow-400 to-yellow-500 text-black font-bold rounded-full hover:from-yellow-300 hover:to-yellow-400 transition-all shadow-lg hover:shadow-[0_0_20px_rgba(250,204,21,0.4)] text-center uppercase tracking-wider text-xs transform hover:scale-105 active:scale-95">
                                Ver Detalles
                            </a>

                            <div class="flex gap-2 w-full">
                                <a href="{{ route('movies.edit', $movie) }}" class="flex-1 py-2.5 bg-gray-800/80 backdrop-blur-md text-white text-xs font-bold rounded-lg hover:bg-gray-700 transition-all text-center border border-white/10 hover:border-white/30 hover:text-yellow-200 flex items-center justify-center">
                                    Editar
                                </a>

                                <form action="{{ route('movies.destroy', $movie) }}" method="POST" onsubmit="return confirm('¿Estás seguro de querer eliminar &quot;{{ $movie->title }}&quot;?');" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full h-full bg-red-600/80 backdrop-blur-md text-white text-xs font-bold rounded-lg hover:bg-red-500 transition-all text-center border border-transparent hover:border-red-400/50 hover:shadow-[0_0_15px_rgba(239,68,68,0.4)] flex items-center justify-center">
                                        Borrar
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>

                    {{-- INFORMACIÓN DE LA PELÍCULA --}}
                    <div class="flex flex-col gap-1.5 relative z-0 group-hover:z-10">
                        <div class="text-xs font-medium text-gray-400 flex items-center gap-2 truncate">
                            <span class="bg-gray-800/50 px-2 py-0.5 rounded text-gray-300">{{ $movie->year }}</span>
                            @if($movie->genres->isNotEmpty())
                                <span class="text-gray-600">•</span>
                                <span class="truncate text-gray-400 group-hover:text-gray-300 transition-colors" title="{{ $movie->genres->pluck('name')->join(' / ') }}">
                                    {{ $movie->genres->take(2)->pluck('name')->join(' / ') }}
                                    @if($movie->genres->count() > 2)<span>...</span>@endif
                                </span>
                            @endif
                        </div>

                        <h3 class="text-white font-bold text-lg leading-tight truncate group-hover:text-yellow-400 transition-colors duration-300" title="{{ $movie->title }}">
                            <a href="{{ route('movies.show', $movie) }}" class="hover:underline focus:outline-none focus:underline">
                                {{ $movie->title }}
                            </a>
                        </h3>
                    </div>

                </div>
            @empty
                {{-- ESTADO VACÍO (SIN CAMBIOS) --}}
                <div class="col-span-full flex flex-col items-center justify-center py-32 text-center relative">
                    <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none select-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-[500px] h-[500px] text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.82 2H4.18C2.97602 2 2 2.97602 2 4.18V19.82C2 21.024 2.97602 22 4.18 22H19.82C21.024 22 22 21.024 22 19.82V4.18C22 2.97602 21.024 2 19.82 2ZM4 4H8V8H4V4ZM4 10H8V14H4V10ZM8 20H4V16H8V20ZM10 4H14V8H10V4ZM14 20H10V16H14V20ZM20 20H16V16H16.002V16.004L20.002 20.004V20H20ZM20 14H16V10H20V14ZM20 8H16V4H20V8Z" />
                        </svg>
                    </div>
                    <div class="relative mb-8 group">
                        <div class="absolute inset-0 bg-yellow-400/20 rounded-full blur-3xl group-hover:bg-yellow-400/30 transition-all duration-700"></div>
                        <div class="w-28 h-28 bg-[#16181c] rounded-3xl flex items-center justify-center border-2 border-yellow-400/20 group-hover:border-yellow-400/50 shadow-xl relative z-10 transition-all duration-500 group-hover:-translate-y-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-yellow-400 opacity-80 group-hover:opacity-100 transition-all duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-black text-white mb-4 font-['Outfit'] leading-tight">Tu colección está esperando</h3>
                    <p class="text-gray-400 mb-10 max-w-md mx-auto text-lg">Empieza a construir tu biblioteca personal añadiendo tu primera película hoy mismo.</p>
                    <a href="{{ route('movies.create') }}" class="group relative inline-flex items-center justify-center px-8 py-4 font-black text-sm text-black transition-all duration-300 bg-gradient-to-r from-yellow-400 to-yellow-500 font-['Outfit'] rounded-full hover:from-yellow-300 hover:to-yellow-400 hover:shadow-[0_0_35px_rgba(250,204,21,0.6)] hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 overflow-hidden">
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/40 to-transparent -translate-x-[150%] group-hover:translate-x-[150%] transition-transform duration-700 ease-in-out z-10"></span>
                        <span class="relative z-20 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Añadir Primera Película
                        </span>
                    </a>
                </div>
            @endforelse

        </div>

        <div class="mt-16 flex justify-center opacity-0 transition-opacity duration-700 delay-700" :class="loaded ? 'opacity-100' : ''">
        </div>
    </div>
@endsection
