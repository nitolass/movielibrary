@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-6">
        {{-- ENCABEZADO CON BOTONES --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white font-['Outfit']">
                Gestión de <span class="text-yellow-400">Usuarios</span>
            </h1>

            {{-- Grupo de botones --}}
            <div class="flex items-center gap-4">
                {{-- BOTÓN PDF SIMPLE --}}
                <a href="{{ route('admin.pdf.users') }}" target="_blank" class="flex items-center gap-2 bg-red-600/20 text-red-400 border border-red-500/30 hover:bg-red-600 hover:text-white hover:border-transparent transition-all px-4 py-2.5 rounded-xl font-bold text-sm shadow-lg hover:shadow-red-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    Generar PDF
                </a>

                {{-- BOTÓN NUEVO USUARIO --}}
                <a href="{{ route('admin.users.create') }}" class="flex items-center gap-2 px-5 py-2.5 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-300 shadow-[0_0_15px_rgba(250,204,21,0.4)] transition-all">
                    <span>+ Nuevo Usuario</span>
                </a>
            </div>
        </div>

        {{-- TABLA DE USUARIOS --}}
        <div class="bg-[#0f1115] border border-white/5 rounded-xl overflow-hidden shadow-xl">
            <table class="min-w-full leading-normal text-left">
                <thead>
                <tr class="bg-white/5 text-gray-400 uppercase text-xs font-bold tracking-wider border-b border-white/5">
                    <th class="py-4 px-6">ID</th>
                    <th class="py-4 px-6">Nombre Completo</th>
                    <th class="py-4 px-6">Email</th>
                    <th class="py-4 px-6">Rol</th>
                    {{-- ✅ NUEVA COLUMNA DE ACCIONES --}}
                    <th class="py-4 px-6 text-right">Acciones</th>
                </tr>
                </thead>
                <tbody class="text-gray-300 text-sm">
                @foreach($users as $user)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                        <td class="py-4 px-6 font-mono text-xs text-gray-500">{{ $user->id }}</td>
                        <td class="py-4 px-6 font-bold text-white">{{ $user->name }} {{ $user->surname }}</td>
                        <td class="py-4 px-6">{{ $user->email }}</td>
                        <td class="py-4 px-6">
                            @php
                                $esAdmin = optional($user->role)->name === 'admin';
                                $clase = $esAdmin ? 'bg-red-500/20 text-red-400 border-red-500/30' : 'bg-blue-500/20 text-blue-400 border-blue-500/30';
                                $rol = optional($user->role)->name ?? 'Sin Rol';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $clase }}">
                                {{ ucfirst($rol) }}
                            </span>
                        </td>

                        {{-- ✅ NUEVO BOTÓN PARA VER DETALLE (Y ACCEDER AL PDF COMPLEJO) --}}
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('admin.users.show', $user) }}" class="text-gray-400 hover:text-white transition-colors font-bold text-sm bg-white/5 hover:bg-white/10 px-3 py-1.5 rounded-lg border border-white/5">
                                Ver Detalle
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
