@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-[#0f1115] px-4">
        <div class="max-w-md w-full bg-[#16181c] border border-white/5 rounded-2xl p-8 text-center shadow-2xl">

            <div class="w-20 h-20 bg-yellow-400/10 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>

            <h2 class="text-3xl font-bold text-white mb-3 font-['Outfit']">{{ __('Únete a MovieHub') }}</h2>
            <p class="text-gray-400 mb-8">
                {{ __('Necesitas iniciar sesión para añadir películas a tus listas, valorarlas o marcarlas como vistas. ¡Es gratis!') }}
            </p>

            <div class="space-y-4">
                <a href="{{ route('login') }}" class="block w-full py-3.5 px-6 bg-yellow-400 hover:bg-yellow-300 text-black font-bold rounded-xl transition-all shadow-[0_0_15px_rgba(250,204,21,0.4)]">
                    {{ __('Iniciar Sesión') }}
                </a>

                <a href="{{ route('register') }}" class="block w-full py-3.5 px-6 bg-transparent border border-gray-600 text-white font-bold rounded-xl hover:bg-white/5 transition-all">
                    {{ __('Crear una cuenta') }}
                </a>
            </div>

            <div class="mt-8 border-t border-white/5 pt-6">
                <a href="{{ route('movies.index') }}" class="text-gray-500 hover:text-white text-sm transition-colors">
                    &larr; {{ __('Volver al catálogo') }}
                </a>
            </div>
        </div>
    </div>
@endsection
