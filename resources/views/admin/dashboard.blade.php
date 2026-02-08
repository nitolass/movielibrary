<x-app-layout>
    <div class="py-8" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 transition-all duration-700 opacity-0 translate-y-4"
             :class="loaded ? 'opacity-100 translate-y-0' : ''">

            {{-- HEADER DEL DASHBOARD --}}
            <div class="relative p-10 bg-gradient-to-br from-gray-900 to-[#16181c] border border-white/10 rounded-3xl shadow-2xl overflow-hidden group">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-96 h-96 bg-yellow-500/10 rounded-full blur-3xl pointer-events-none group-hover:bg-yellow-500/20 transition-all duration-700"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-500/5 rounded-full blur-3xl -ml-10 -mb-10 pointer-events-none"></div>

                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <span class="px-3 py-1 rounded-full bg-yellow-400/10 border border-yellow-400/20 text-yellow-400 text-[10px] font-bold uppercase tracking-widest">
                                {{ __('Miembro Premium') }}
                            </span>
                        </div>
                        <h3 class="text-4xl md:text-5xl font-black text-white mb-3 leading-tight tracking-tight">
                            {{ __('Hola') }}, <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-amber-300">{{ Auth::user()->name }}</span>
                        </h3>
                        <p class="text-gray-400 text-base md:text-lg max-w-2xl font-light">
                            "{{ __('El cine no es un trozo de vida, es un pedazo de pastel.') }}" — Alfred Hitchcock
                        </p>
                    </div>

                    <div class="hidden md:block">
                        <a href="{{ route('movies.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white/5 hover:bg-yellow-400 hover:text-black border border-white/10 hover:border-yellow-400 rounded-xl text-white font-bold transition-all duration-300 group/btn">
                            {{ __('Ir al catálogo') }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover/btn:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- CARD EXPLORAR --}}
                <a href="{{ Route::has('movies.index') ? route('movies.index') : '#' }}" class="group relative p-1 rounded-3xl bg-gradient-to-b from-white/10 to-white/5 hover:from-yellow-400/50 hover:to-yellow-600/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_0_30px_rgba(250,204,21,0.2)]">
                    <div class="relative h-full p-8 bg-[#0f1115] rounded-[22px] flex flex-col items-start overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-400/10 rounded-full blur-2xl -mr-16 -mt-16 group-hover:bg-yellow-400/20 transition-colors"></div>

                        <div class="w-14 h-14 bg-yellow-400 rounded-2xl flex items-center justify-center mb-6 text-black shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </div>
                        <h4 class="text-2xl font-black text-white mb-2 group-hover:text-yellow-400 transition-colors">{{ __('Explorar') }}</h4>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            {{ __('Navega por el catálogo completo. Filtra por género y descubre tu próxima obsesión.') }}
                        </p>
                    </div>
                </a>

                {{-- CARD AJUSTES --}}
                <a href="{{ route('profile.edit') }}" class="group relative p-1 rounded-3xl bg-gradient-to-b from-white/10 to-white/5 hover:from-purple-400/50 hover:to-purple-600/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_0_30px_rgba(168,85,247,0.2)]">
                    <div class="relative h-full p-8 bg-[#0f1115] rounded-[22px] flex flex-col items-start overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-2xl -mr-16 -mt-16 group-hover:bg-purple-500/20 transition-colors"></div>

                        <div class="w-14 h-14 bg-purple-500 rounded-2xl flex items-center justify-center mb-6 text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h4 class="text-2xl font-black text-white mb-2 group-hover:text-purple-400 transition-colors">{{ __('Configuración') }}</h4>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            {{ __('Gestiona tu cuenta, actualiza tu contraseña y personaliza tu experiencia.') }}
                        </p>
                    </div>
                </a>

                {{-- 3. CARD REPORTE / PDF (NUEVO - SUSTITUYE FAVORITOS) --}}
                <a href="{{ route('admin.pdf.dashboard_report') }}" target="_blank" class="group relative p-1 rounded-3xl bg-gradient-to-b from-white/10 to-white/5 hover:from-red-500/50 hover:to-orange-500/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_0_30px_rgba(248,113,113,0.3)]">
                    <div class="relative h-full p-8 bg-[#0f1115] rounded-[22px] flex flex-col items-start overflow-hidden group-hover:bg-[#16181c] transition-colors">

                        {{-- Efecto de fondo --}}
                        <div class="absolute top-0 right-0 w-40 h-40 bg-red-500/10 rounded-full blur-3xl -mr-20 -mt-20 group-hover:bg-red-500/20 transition-colors duration-500"></div>

                        {{-- Icono --}}
                        <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-orange-500 rounded-2xl flex items-center justify-center mb-6 text-white shadow-lg shadow-red-500/20 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>

                        {{-- Texto --}}
                        <h4 class="text-2xl font-black text-white mb-2 group-hover:text-red-400 transition-colors">{{ __('Informe de Estado') }}</h4>
                        <p class="text-gray-400 text-sm leading-relaxed mb-4">
                            {{ __('Genera un análisis completo del catálogo: estadísticas, tops y distribución por géneros.') }}
                        </p>

                        {{-- Botón simulado --}}
                        <span class="mt-auto text-xs font-bold uppercase tracking-wider text-red-400 border border-red-500/30 px-3 py-1 rounded-lg bg-red-500/10 group-hover:bg-red-500 group-hover:text-white transition-all flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            {{ __('Descargar PDF') }}
                        </span>
                    </div>
                </a>

            </div>


            {{-- CURIOSIDAD DEL CINE --}}
            <div class="w-full h-56 rounded-3xl relative overflow-hidden flex items-center border border-white/10 shadow-2xl select-none">
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center opacity-30"></div>
                <div class="absolute inset-0 opacity-[0.05]" style="background-image: url('https://www.transparenttextures.com/patterns/stardust.png');"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-gray-900/90 to-transparent"></div>

                <div class="relative z-10 px-10 md:px-14 flex flex-col justify-center h-full max-w-4xl">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-yellow-500"></span>
                        </span>
                        <span class="text-yellow-400 font-bold text-xs uppercase tracking-[0.2em]">{{ __('Curiosidad del Cine') }}</span>
                    </div>

                    <h3 class="text-3xl md:text-4xl font-black text-white mb-3">
                        {{ __('La Magia de los') }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-amber-500">{{ __('24 Fotogramas') }}</span>
                    </h3>

                    <p class="text-gray-400 text-sm md:text-base leading-relaxed">
                        {{ __('¿Sabías que el estándar de 24 cuadros por segundo se estableció en 1926? No solo porque era la velocidad más barata para engañar al ojo humano, sino porque era la mínima necesaria para sincronizar el sonido en las primeras películas sonoras.') }}
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
