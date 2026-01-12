<x-guest-layout>
    <div class="w-full sm:max-w-md px-8 py-10 bg-[#16181c]/85 backdrop-blur-xl border border-white/10 rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.5)] relative overflow-hidden"
         x-data="{ loaded: false }"
         x-init="setTimeout(() => loaded = true, 100)">

        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-48 h-48 bg-red-500/10 rounded-full blur-3xl -mt-24 pointer-events-none"></div>

        <div class="relative z-10 transition-all duration-700 opacity-0 translate-y-4"
             :class="loaded ? 'opacity-100 translate-y-0' : ''">

            <div class="mb-8 text-center">
                <div class="flex justify-center mb-5">
                    <div class="w-16 h-16 bg-gray-800/50 rounded-2xl flex items-center justify-center border border-white/10 text-yellow-400 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.956 11.956 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                </div>

                <h2 class="text-xl font-bold text-white">Zona Segura</h2>
                <p class="text-sm text-gray-400 mt-2 leading-relaxed px-2">
                    {{ __('Esta es una área segura de la aplicación. Por favor, confirma tu contraseña para continuar.') }}
                </p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                @csrf

                <div x-data="{ show: false }">
                    <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Contraseña</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 group-focus-within:text-yellow-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>

                        <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="Tu contraseña actual"
                               class="block w-full pl-12 pr-12 py-3 bg-[#0f1115] border border-gray-700 text-gray-100 rounded-xl focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 focus:outline-none transition-all placeholder-gray-600 shadow-inner sm:text-sm">

                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-white transition-colors focus:outline-none">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg x-show="show" style="display: none;" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.976m4.868-4.32C9.445 4.3 10.707 4 12 4c4.478 0 8.268 2.943 9.542 7 0 1.126-.33 2.193-.905 3.129M9 9a3 3 0 013-3m-6 11l15-15" /></svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs font-bold" />
                </div>

                <div class="pt-2 flex flex-col gap-3">
                    <button type="submit" class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl text-sm font-black text-black bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-300 hover:to-yellow-400 shadow-lg hover:shadow-yellow-400/50 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-300 uppercase tracking-widest overflow-hidden">
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-[150%] group-hover:translate-x-[150%] transition-transform duration-700 ease-in-out"></span>
                        <span class="relative z-10">Confirmar</span>
                    </button>

                    <a href="javascript:history.back()" class="text-center text-xs text-gray-500 hover:text-white py-2 transition-colors">
                        Cancelar y volver
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
