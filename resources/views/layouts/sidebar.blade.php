<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0f1115] border-r border-white/5 flex flex-col transition-transform duration-300 transform -translate-x-full md:translate-x-0">

    <div class="h-20 flex items-center px-8 border-b border-white/5">
        <a href="{{ route('dashboard') }}" class="text-3xl font-black tracking-tighter text-white font-['Outfit']">
            MovieHub<span class="text-yellow-400">.</span>
        </a>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">

        <p class="px-4 text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Menu Principal</p>

        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-yellow-400 text-black font-bold shadow-[0_0_15px_rgba(250,204,21,0.4)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Inicio</span>
        </a>

        <a href="{{ route('movies.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('movies.*') ? 'bg-yellow-400 text-black font-bold shadow-[0_0_15px_rgba(250,204,21,0.4)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <span>Catálogo</span>
        </a>

        <a href="#" class="flex items-center justify-between px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-all group">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:text-purple-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Ver Luego</span>
            </div>
        </a>

        <a href="#" class="flex items-center justify-between px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-all group">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:text-green-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <span>Vistas</span>
            </div>
        </a>

        <a href="{{ Route::has('reviews.index') ? route('reviews.index') : '#' }}" class="flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ request()->routeIs('reviews.*') ? 'bg-yellow-400 text-black font-bold' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }} group">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('reviews.*') ? '' : 'group-hover:text-blue-400 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
                <span>Mis Reseñas</span>
            </div>
        </a>

        <a href="#" class="flex items-center justify-between px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition-all group">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <span>Favoritos</span>
            </div>
        </a>

        <div class="mt-6 pt-6 border-t border-white/5">
            <p class="px-4 text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Cuenta</p>

            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('profile.edit') ? 'bg-yellow-400 text-black font-bold' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Ajustes</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </nav>

    <div class="p-4 border-t border-white/5 bg-[#0f1115]">

        @auth
            <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-800/50 border border-white/5 hover:border-white/20 transition-colors cursor-pointer group">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-yellow-400 to-yellow-600 flex items-center justify-center text-black font-bold border-2 border-transparent group-hover:border-white transition-all">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <h4 class="text-sm font-bold text-white truncate group-hover:text-yellow-400 transition-colors">{{ Auth::user()->name }}</h4>
                    <p class="text-xs text-gray-400 truncate">Miembro</p>
                </div>
            </div>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full p-3 rounded-xl bg-yellow-400 text-black font-bold hover:bg-yellow-300 transition-colors shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <span>Iniciar Sesión</span>
            </a>
        @endguest

    </div>
</aside>
