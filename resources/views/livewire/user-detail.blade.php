<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-white transition-colors mb-2 inline-block">&larr; {{ __('Volver al listado') }}</a>
            <h1 class="text-3xl font-bold text-white font-['Outfit']">
                {{ __('Ficha de') }} <span class="text-yellow-400">{{ $user->name }}</span>
            </h1>
        </div>
        <a href="{{ route('admin.pdf.userReport', $user->id) }}" target="_blank" class="flex items-center gap-2 bg-red-600 hover:bg-red-500 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg transition-all">
            <span>{{ __('Descargar Informe') }}</span>
        </a>
    </div>

    <div class="bg-[#0f1115] border border-white/5 rounded-2xl p-8 shadow-xl mb-8">
        <h3 class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-6 border-b border-white/5 pb-2">{{ __('Información Personal') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <span class="block text-gray-500 text-sm mb-1">{{ __('Nombre Completo') }}</span>
                <span class="text-xl text-white font-bold">{{ $user->name }} {{ $user->surname }}</span>
            </div>
            <div>
                <span class="block text-gray-500 text-sm mb-1">{{ __('Email') }}</span>
                <span class="text-xl text-white font-mono">{{ $user->email }}</span>
            </div>
            <div>
                <span class="block text-gray-500 text-sm mb-1">{{ __('Estado Email') }}</span>
                <span class="text-sm font-bold {{ $user->email_verified_at ? 'text-green-400' : 'text-red-400' }}">
                    {{ $user->email_verified_at ? __('Verificado') : __('No Verificado') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Watchlist (Solo lectura aquí) --}}
    <div class="bg-[#0f1115] border border-white/5 rounded-2xl p-8 shadow-xl">
        <h3 class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-6 border-b border-white/5 pb-2">
            {{ __('Películas Pendientes') }} ({{ $user->watchLater->count() }})
        </h3>
        @if($user->watchLater->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($user->watchLater as $movie)
                    <div class="aspect-[2/3] rounded-lg overflow-hidden bg-gray-800 border border-white/5">
                        @if($movie->poster)
                            <img src="{{ asset('storage/' . $movie->poster) }}" alt="" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-600 text-xs">{{ __('Sin Imagen') }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 italic">{{ __('Sin películas pendientes.') }}</p>
        @endif
    </div>
</div>
