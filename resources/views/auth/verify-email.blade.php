<x-guest-layout>
    <div class="w-full sm:max-w-md px-8 py-10 bg-[#16181c]/85 backdrop-blur-xl border border-white/10 rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.5)] relative overflow-hidden"
         x-data="{ loaded: false }"
         x-init="setTimeout(() => loaded = true, 100)">

        <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-500/10 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl -ml-16 -mb-16 pointer-events-none"></div>

        <div class="relative z-10 transition-all duration-700 opacity-0 translate-y-4"
             :class="loaded ? 'opacity-100 translate-y-0' : ''">

            <div class="text-center mb-6">
                <a href="/" class="inline-block group">
                    <h1 class="text-3xl font-black text-white tracking-tighter group-hover:scale-105 transition-transform">
                        MovieHub<span class="text-yellow-400">.</span>
                    </h1>
                </a>
            </div>

            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-yellow-400/10 rounded-full flex items-center justify-center border border-yellow-400/20 shadow-[0_0_30px_rgba(250,204,21,0.2)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <div class="mb-6 text-center">
                <h2 class="text-lg font-bold text-white mb-2">Verifica tu correo electrónico</h2>
                <p class="text-sm text-gray-400 leading-relaxed">
                    {{ __('Gracias por registrarte. Antes de empezar a coleccionar cine, ¿podrías verificar tu dirección haciendo clic en el enlace que te acabamos de enviar?') }}
                </p>
                <p class="text-xs text-gray-500 mt-2">
                    {{ __('Si no recibiste el correo, con gusto te enviaremos otro.') }}
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-center">
                    <div class="flex items-center justify-center gap-2 text-green-400 font-bold text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ __('Enlace enviado correctamente.') }}</span>
                    </div>
                    <p class="text-xs text-green-300/70 mt-1">Revisa tu bandeja de entrada o spam.</p>
                </div>
            @endif

            <div class="mt-6 flex flex-col gap-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl text-sm font-black text-black bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-300 hover:to-yellow-400 shadow-lg hover:shadow-yellow-400/50 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-300 uppercase tracking-widest overflow-hidden">
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-[150%] group-hover:translate-x-[150%] transition-transform duration-700 ease-in-out"></span>
                        <span class="relative flex items-center gap-2 z-10">
                            {{ __('Reenviar Email') }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:rotate-12 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </span>
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="text-center">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-white transition-colors underline decoration-transparent hover:decoration-white underline-offset-4">
                        {{ __('Cerrar Sesión') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
