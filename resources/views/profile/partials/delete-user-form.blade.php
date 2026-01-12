<section class="space-y-6 relative overflow-hidden bg-gray-900/60 backdrop-blur-md border border-red-500/30 rounded-3xl p-8 transition-all hover:border-red-500/50 hover:shadow-[0_0_30px_rgba(220,38,38,0.15)] group">

    <div class="absolute -top-10 -right-10 w-40 h-40 bg-red-600/10 rounded-full blur-3xl pointer-events-none group-hover:bg-red-600/20 transition-all"></div>

    <header>
        <h2 class="text-2xl font-black text-red-500 uppercase tracking-widest flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            {{ __('Eliminar Cuenta') }}
        </h2>

        <p class="mt-4 text-sm text-gray-400 max-w-xl leading-relaxed">
            {{ __('Una vez que se elimine tu cuenta, todos sus recursos y datos se eliminarán permanentemente. Antes de eliminar tu cuenta, descarga cualquier dato o información que desees conservar.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600/80 hover:bg-red-600 text-white border-0 shadow-[0_0_15px_rgba(220,38,38,0.4)] hover:shadow-[0_0_25px_rgba(220,38,38,0.6)] px-6 py-3 rounded-xl transition-all duration-300 font-bold tracking-wide"
    >
        {{ __('Eliminar mi cuenta') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>

        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-gray-900 border border-white/10 rounded-lg">
            @csrf
            @method('delete')

            <h2 class="text-xl font-bold text-white mb-2">
                {{ __('¿Estás seguro de que quieres eliminar tu cuenta?') }}
            </h2>

            <p class="mt-2 text-sm text-gray-400">
                {{ __('Una vez que se elimine tu cuenta, todos sus recursos y datos se eliminarán permanentemente. Por favor, introduce tu contraseña para confirmar que deseas eliminar permanentemente tu cuenta.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Contraseña') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 bg-gray-800 border-gray-700 text-white placeholder-gray-500 focus:border-red-500 focus:ring-red-500 rounded-xl px-4 py-3"
                    placeholder="{{ __('Escribe tu contraseña') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-400" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="bg-gray-800 text-gray-300 border-gray-700 hover:bg-gray-700 hover:text-white transition-colors">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="bg-red-600 hover:bg-red-500 text-white border-0 shadow-lg shadow-red-900/50">
                    {{ __('Eliminar Cuenta') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
