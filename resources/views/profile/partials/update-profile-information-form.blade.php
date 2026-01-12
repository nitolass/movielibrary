<section class="relative bg-gray-900/60 backdrop-blur-md border border-white/10 rounded-3xl p-8 shadow-[0_0_40px_rgba(0,0,0,0.3)] overflow-hidden">

    <div class="absolute top-0 left-0 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl pointer-events-none -ml-16 -mt-16"></div>

    <header class="relative z-10 mb-6">
        <h2 class="text-2xl font-black text-white tracking-tight flex items-center gap-3">
            <div class="p-2 bg-blue-500/10 rounded-lg text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            {{ __('Información del Perfil') }}
        </h2>

        <p class="mt-2 text-sm text-gray-400 max-w-xl">
            {{ __("Actualiza la información de perfil y la dirección de correo electrónico de tu cuenta.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5 relative z-10">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nombre')" class="text-gray-300 font-bold ml-1" />
            <x-text-input id="name" name="name" type="text"
                          class="mt-2 block w-full bg-gray-800/50 border-gray-700 text-gray-100 focus:border-yellow-400 focus:ring-yellow-400 rounded-xl py-3 px-4 shadow-inner placeholder-gray-500 transition-all"
                          :value="old('name', $user->name)"
                          required autofocus autocomplete="name"
                          placeholder="Tu nombre público" />
            <x-input-error class="mt-2 text-red-400 font-medium" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-gray-300 font-bold ml-1" />
            <x-text-input id="email" name="email" type="email"
                          class="mt-2 block w-full bg-gray-800/50 border-gray-700 text-gray-100 focus:border-yellow-400 focus:ring-yellow-400 rounded-xl py-3 px-4 shadow-inner placeholder-gray-500 transition-all"
                          :value="old('email', $user->email)"
                          required autocomplete="username"
                          placeholder="ejemplo@correo.com" />
            <x-input-error class="mt-2 text-red-400 font-medium" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 rounded-xl bg-yellow-900/20 border border-yellow-500/20">
                    <p class="text-sm text-yellow-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Tu dirección de correo no está verificada.') }}
                    </p>

                    <button form="send-verification" class="mt-2 text-sm font-bold text-yellow-400 hover:text-yellow-300 underline decoration-2 decoration-yellow-400/50 hover:decoration-yellow-400 transition-all focus:outline-none">
                        {{ __('Haz clic aquí para reenviar el email de verificación.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-3 text-sm font-medium text-green-400 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu correo.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-6 py-3 bg-yellow-400 text-black font-black rounded-full shadow-[0_0_15px_rgba(250,204,21,0.4)] hover:shadow-[0_0_25px_rgba(250,204,21,0.6)] hover:-translate-y-0.5 transition-all duration-300 uppercase tracking-wider text-sm">
                {{ __('Guardar') }}
            </button>

            @if (session('status') === 'profile-updated')
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
                    {{ __('Guardado.') }}
                </p>
            @endif
        </div>
    </form>
</section>
