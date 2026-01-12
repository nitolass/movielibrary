<section class="relative bg-gray-900/60 backdrop-blur-md border border-white/10 rounded-3xl p-8 shadow-[0_0_40px_rgba(0,0,0,0.3)] overflow-hidden">

    <div class="absolute top-0 right-0 w-64 h-64 bg-yellow-500/5 rounded-full blur-3xl pointer-events-none -mr-16 -mt-16"></div>

    <header class="relative z-10 mb-6">
        <h2 class="text-2xl font-black text-white tracking-tight flex items-center gap-3">
            <div class="p-2 bg-yellow-400/10 rounded-lg text-yellow-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            {{ __('Actualizar Contraseña') }}
        </h2>

        <p class="mt-2 text-sm text-gray-400 max-w-xl">
            {{ __('Asegúrate de que tu cuenta esté usando una contraseña larga y aleatoria para mantenerte seguro.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5 relative z-10">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Contraseña Actual')" class="text-gray-300 font-bold ml-1" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                          class="mt-2 block w-full bg-gray-800/50 border-gray-700 text-gray-100 focus:border-yellow-400 focus:ring-yellow-400 rounded-xl py-3 px-4 shadow-inner placeholder-gray-500 transition-all"
                          autocomplete="current-password"
                          placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-400 font-medium" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <x-input-label for="update_password_password" :value="__('Nueva Contraseña')" class="text-gray-300 font-bold ml-1" />
                <x-text-input id="update_password_password" name="password" type="password"
                              class="mt-2 block w-full bg-gray-800/50 border-gray-700 text-gray-100 focus:border-yellow-400 focus:ring-yellow-400 rounded-xl py-3 px-4 shadow-inner placeholder-gray-500 transition-all"
                              autocomplete="new-password"
                              placeholder="Nueva contraseña" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-400 font-medium" />
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Contraseña')" class="text-gray-300 font-bold ml-1" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                              class="mt-2 block w-full bg-gray-800/50 border-gray-700 text-gray-100 focus:border-yellow-400 focus:ring-yellow-400 rounded-xl py-3 px-4 shadow-inner placeholder-gray-500 transition-all"
                              autocomplete="new-password"
                              placeholder="Repite la nueva contraseña" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-400 font-medium" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-6 py-3 bg-yellow-400 text-black font-black rounded-full shadow-[0_0_15px_rgba(250,204,21,0.4)] hover:shadow-[0_0_25px_rgba(250,204,21,0.6)] hover:-translate-y-0.5 transition-all duration-300 uppercase tracking-wider text-sm">
                {{ __('Guardar Cambios') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-400 font-bold flex items-center gap-1"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Guardado correctamente.') }}
                </p>
            @endif
        </div>
    </form>
</section>
