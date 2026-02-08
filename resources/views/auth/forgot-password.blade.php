<x-guest-layout>
    <div class="w-full sm:max-w-md px-8 py-10 bg-[#16181c]/85 backdrop-blur-xl border border-white/10 rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.5)] relative overflow-hidden"
         x-data="{ loaded: false }"
         x-init="setTimeout(() => loaded = true, 100)">

        <div class="absolute top-0 left-0 w-40 h-40 bg-purple-500/10 rounded-full blur-3xl -ml-10 -mt-10 pointer-events-none"></div>

        <div class="relative z-10 transition-all duration-700 opacity-0 translate-y-4"
             :class="loaded ? 'opacity-100 translate-y-0' : ''">

            <div class="mb-6 text-center">
                <a href="/" class="inline-block mb-4 group">
                    <h1 class="text-3xl font-black text-white tracking-tighter group-hover:scale-105 transition-transform">
                        MovieHub<span class="text-yellow-400">.</span>
                    </h1>
                </a>

                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 bg-gray-800/50 rounded-2xl flex items-center justify-center border border-white/10 text-yellow-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                </div>

                <h2 class="text-xl font-bold text-white">{{ __('¿Olvidaste tu contraseña?') }}</h2>
                <p class="text-sm text-gray-400 mt-2 leading-relaxed">
                    {{ __('No te preocupes. Indícanos tu email y te enviaremos un enlace para que puedas crear una nueva.') }}
                </p>
            </div>

            <x-auth-session-status class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-center text-green-400 font-bold text-sm" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">{{ __('Correo Electrónico') }}</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 group-focus-within:text-yellow-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="{{ __('tu@email.com') }}"
                               class="block w-full pl-12 pr-4 py-3 bg-[#0f1115] border border-gray-700 text-gray-100 rounded-xl focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 focus:outline-none transition-all placeholder-gray-600 shadow-inner sm:text-sm">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs font-bold" />
                </div>

                <button type="submit" class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl text-sm font-black text-black bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-300 hover:to-yellow-400 shadow-lg hover:shadow-yellow-400/50 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-300 uppercase tracking-widest overflow-hidden">
                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-[150%] group-hover:translate-x-[150%] transition-transform duration-700 ease-in-out"></span>
                    <span class="relative flex items-center gap-2 z-10">
                        {{ __('Enviar enlace') }}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </span>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-white/5 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-white transition-colors text-sm font-medium group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Volver a iniciar sesión') }}
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>
