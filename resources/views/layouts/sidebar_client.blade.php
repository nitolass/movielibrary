{{--
    ARCHIVO: resources/views/layouts/navigation/sidebar-client.blade.php
    DESCRIPCIÓN: Menú lateral exclusivo para clientes (rol 'user').
--}}

{{-- SECCIÓN 1: MENÚ PRINCIPAL --}}
<div class="space-y-2">
    <p class="px-4 text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Menú Principal</p>

    {{-- Inicio --}}
    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-yellow-400 text-black font-bold shadow-[0_0_15px_rgba(250,204,21,0.4)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <span>Inicio</span>
    </a>

    {{-- Catálogo (Ruta de Usuario) --}}
    <a href="{{ route('user.movies.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('user.movies.*') ? 'bg-yellow-400 text-black font-bold shadow-[0_0_15px_rgba(250,204,21,0.4)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
        </svg>
        <span>Catálogo</span>
    </a>
</div>

{{-- SECCIÓN 2: BIBLIOTECA (Lo que pediste) --}}
<div class="mt-8 pt-6 border-t border-white/5 space-y-2">
    <p class="px-4 text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Biblioteca</p>

    {{-- Favoritos --}}
    <a href="{{ route('user.favorites') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('user.favorites') ? 'bg-yellow-400 text-black font-bold' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
        <span>Favoritos</span>
    </a>

    {{-- Ver más tarde --}}
    <a href="{{ route('user.watch_later') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('user.watch_later') ? 'bg-yellow-400 text-black font-bold' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>Ver más tarde</span>
    </a>

    {{-- Ya Vistas --}}
    <a href="{{ route('user.watched') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('user.watched') ? 'bg-yellow-400 text-black font-bold' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
        <span>Ya vistas</span>
    </a>

    {{-- Puntuadas --}}
    <a href="{{ route('user.rated') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('user.rated') ? 'bg-yellow-400 text-black font-bold' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
        </svg>
        <span>Puntuadas</span>
    </a>
</div>
