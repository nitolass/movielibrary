<x-guest-layout>
    <div class="w-full sm:max-w-md px-8 py-10 bg-[#16181c]/85 backdrop-blur-xl border border-white/10 rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.5)] relative overflow-hidden"
         x-data="{ loaded: false }"
         x-init="setTimeout(() => loaded = true, 100)">

        <div class="absolute top-0 left-0 w-32 h-32 bg-purple-500/10 rounded-full blur-3xl -ml-16 -mt-16 pointer-events-none"></div>

        <div class="relative z-10 transition-all duration-700 opacity-0 translate-y-4"
             :class="loaded ? 'opacity-100 translate-y-0' : ''">

            <div class="mb-8 text-center">
                <a href="/" class="inline-block mb-4 group">
                    <h1 class="text-3xl font-black text-white tracking-tighter group-hover:scale-105 transition-transform">
                        MovieHub<span class="text-yellow-400">.</span>
                    </h1>
                </a>
                <h2 class="text-lg font-bold text-gray-200">Crea tu cuenta</h2>
                <p class="text-gray-500 text-xs mt-1">Empieza a coleccionar cine hoy mismo</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Nombre Completo</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 group-focus-within:text-yellow-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Tu Nombre"
                               class="block w-full pl-12 pr-4 py-3 bg-[#0f1115] border border-gray-700 text-gray-100 rounded-xl focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 focus:outline-none transition-all placeholder-gray-600 shadow-inner sm:text-sm">
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400 text-xs font-bold" />
                </div>

                <div>
                    <label for="surname" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Apellido</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 group-focus-within:text-yellow-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .884-.956 2.5-1 2.5H15c-.044 0-1-1.616-1-2.5" />
                            </svg>
                        </div>
                        <input id="surname" type="text" name="surname" :value="old('surname')" required autocomplete="family-name" placeholder="Tu Apellido"
                               class="block w-full pl-12 pr-4 py-3 bg-[#0f1115] border border-gray-700 text-gray-100 rounded-xl focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 focus:outline-none transition-all placeholder-gray-600 shadow-inner sm:text-sm">
                    </div>
                    <x-input-error :messages="$errors->get('surname')" class="mt-2 text-red-400 text-xs font-bold" />
                </div>
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Correo Electrónico</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 group-focus-within:text-yellow-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="ejemplo@moviehub.com"
                               class="block w-full pl-12 pr-4 py-3 bg-[#0f1115] border border-gray-700 text-gray-100 rounded-xl focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 focus:outline-none transition-all placeholder-gray-600 shadow-inner sm:text-sm">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs font-bold" />
                </div>

                <div x-data="{ show: false }" class="space-y-5">

                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Contraseña</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 group-focus-within:text-yellow-400 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>

                            <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password" placeholder="••••••••"
                                   class="block w-full pl-12 pr-12 py-3 bg-[#0f1115] border border-gray-700 text-gray-100 rounded-xl focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 focus:outline-none transition-all placeholder-gray-600 shadow-inner sm:text-sm">

                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-white transition-colors focus:outline-none">
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg x-show="show" style="display: none;" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.976m4.868-4.32C9.445 4.3 10.707 4 12 4c4.478 0 8.268 2.943 9.542 7 0 1.126-.33 2.193-.905 3.129M9 9a3 3 0 013-3m-6 11l15-15" /></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs font-bold" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Confirmar Contraseña</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 group-focus-within:text-yellow-400 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>

                            <input id="password_confirmation" :type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" placeholder="Repite tu contraseña"
                                   class="block w-full pl-12 pr-4 py-3 bg-[#0f1115] border border-gray-700 text-gray-100 rounded-xl focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 focus:outline-none transition-all placeholder-gray-600 shadow-inner sm:text-sm">
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400 text-xs font-bold" />
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl text-sm font-black text-black bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-300 hover:to-yellow-400 shadow-lg hover:shadow-yellow-400/50 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-300 uppercase tracking-widest overflow-hidden">
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-[150%] group-hover:translate-x-[150%] transition-transform duration-700 ease-in-out"></span>
                        <span class="relative flex items-center gap-2 z-10">
                            Registrarse
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </span>
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-6 border-t border-white/5 text-center">
                <p class="text-gray-500 text-xs">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}" class="text-yellow-400 font-bold hover:text-yellow-300 hover:underline transition-all">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
