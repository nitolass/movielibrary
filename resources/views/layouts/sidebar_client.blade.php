<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0f1115] border-r border-white/5 flex flex-col transition-transform duration-300 transform -translate-x-full md:translate-x-0">

    {{-- CABECERA CON LOGO --}}
    <div class="h-20 flex items-center px-8 border-b border-white/5">
        <a href="{{ route('home') }}" class="text-3xl font-black tracking-tighter text-white font-['Outfit']">
            MovieHub<span class="text-yellow-400">.</span>
        </a>
    </div>

    {{-- ZONA DE NAVEGACIÓN SCROLLEABLE --}}
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">

        {{-- 1. MENÚ PRINCIPAL (Visible para TODOS) --}}
        <p class="px-4 text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Menú Principal</p>

        {{-- Inicio --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('home') ? 'bg-yellow-400 text-black font-bold shadow-[0_0_15px_rgba(250,204,21,0.4)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Inicio</span>
        </a>

        {{-- Catálogo --}}
        <a href="{{ route('user.movies.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('user.movies.*') ? 'bg-yellow-400 text-black font-bold shadow-[0_0_15px_rgba(250,204,21,0.4)]' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
            </svg>
            <span>Catálogo</span>
        </a>

        {{-- 2. BIBLIOTECA (SOLO PARA USUARIOS LOGUEADOS) --}}
        @auth
            <div class="mt-6 pt-6 border-t border-white/5">
                <p class="px-4 text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Biblioteca</p>

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

            {{-- 3. CUENTA (SOLO PARA USUARIOS LOGUEADOS) --}}
            <div class="mt-6 pt-6 border-t border-white/5">
                <p class="px-4 text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Cuenta</p>

                {{-- Ajustes / Perfil --}}
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('profile.edit') ? 'bg-yellow-400 text-black font-bold' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Ajustes</span>
                </a>

                {{-- Botón Cerrar Sesión --}}
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
        @else
            {{-- INVITACIÓN A REGISTRARSE (SOLO PARA GUESTS) --}}
            <div class="mt-6 pt-6 border-t border-white/5 px-4">
                <p class="text-xs text-gray-500 mb-3">Únete a la comunidad</p>
                <a href="{{ route('login') }}" class="block w-full text-center py-2 mb-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg text-sm font-bold transition-colors">
                    Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" class="block w-full text-center py-2 bg-yellow-400 hover:bg-yellow-500 text-black rounded-lg text-sm font-bold transition-colors">
                    Registrarse
                </a>
            </div>
        @endauth
    </nav>

    {{-- FOOTER CON USUARIO (Solo logueados) --}}
    @auth
        <div class="p-4 border-t border-white/5 bg-[#0f1115]">
            <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-800/50 border border-white/5 hover:border-white/20 transition-colors cursor-pointer group">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-yellow-400 to-yellow-600 flex items-center justify-center text-black font-bold border-2 border-transparent group-hover:border-white transition-all">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <h4 class="text-sm font-bold text-white truncate group-hover:text-yellow-400 transition-colors">{{ Auth::user()->name }}</h4>
                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->role?->name ?? 'Cliente' }}</p>
                </div>
            </div>
        </div>
    @endauth
</aside>
