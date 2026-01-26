@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-8">

        {{-- ENCABEZADO --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-white transition-colors mb-2 inline-block">&larr; Volver al listado</a>
                <h1 class="text-3xl font-bold text-white font-['Outfit']">
                    Ficha de <span class="text-yellow-400">{{ $user->name }}</span>
                </h1>
            </div>

            {{-- BOTÓN PDF COMPLEJO --}}
            <a href="{{ route('admin.pdf.userReport', $user) }}" target="_blank" class="flex items-center gap-2 bg-red-600 hover:bg-red-500 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg shadow-red-600/20 transition-all transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <span>Descargar Informe Completo</span>
            </a>
        </div>

        {{-- TARJETA DE DATOS PRINCIPALES --}}
        <div class="bg-[#0f1115] border border-white/5 rounded-2xl p-8 shadow-xl mb-8">
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-6 border-b border-white/5 pb-2">Información Personal</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <span class="block text-gray-500 text-sm mb-1">Nombre Completo</span>
                    <span class="text-xl text-white font-bold">{{ $user->name }} {{ $user->surname }}</span>
                </div>
                <div>
                    <span class="block text-gray-500 text-sm mb-1">Correo Electrónico</span>
                    <span class="text-xl text-white font-mono">{{ $user->email }}</span>
                </div>
                <div>
                    <span class="block text-gray-500 text-sm mb-1">Rol en el sistema</span>
                    @php
                        $esAdmin = optional($user->role)->name === 'admin';
                        $clase = $esAdmin ? 'bg-red-500/20 text-red-400 border-red-500/30' : 'bg-blue-500/20 text-blue-400 border-blue-500/30';
                    @endphp
                    <span class="inline-block px-3 py-1 rounded-lg text-sm font-bold border {{ $clase }} mt-1">
                        {{ ucfirst(optional($user->role)->name ?? 'Sin Rol') }}
                    </span>
                </div>
                <div>
                    <span class="block text-gray-500 text-sm mb-1">Miembro desde</span>
                    <span class="text-white">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- LISTA DE PELÍCULAS PENDIENTES (WATCH LATER) --}}
        <div class="bg-[#0f1115] border border-white/5 rounded-2xl p-8 shadow-xl">
            <h3 class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-6 border-b border-white/5 pb-2">
                Películas Pendientes ({{ $user->watchLater->count() }})
            </h3>

            @if($user->watchLater->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @foreach($user->watchLater as $movie)
                        <div class="group relative">
                            {{-- Póster --}}
                            <div class="aspect-[2/3] rounded-lg overflow-hidden bg-gray-800 border border-white/5">
                                @if($movie->poster)
                                    <img src="{{ asset('storage/' . $movie->poster) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-600 text-xs">Sin Imagen</div>
                                @endif
                            </div>
                            <p class="mt-2 text-sm text-gray-300 font-medium truncate">{{ $movie->title }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">Este usuario no tiene películas guardadas para ver más tarde.</p>
            @endif
        </div>

    </div>
@endsection
