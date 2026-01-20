@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white font-['Outfit']">Gestión de <span class="text-yellow-400">Usuarios</span></h1>
            <a href="{{ route('admin.users.create') }}" class="px-5 py-2.5 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-300 shadow-[0_0_15px_rgba(250,204,21,0.4)] transition-all">
                + Nuevo Usuario
            </a>
        </div>

        <div class="bg-[#0f1115] border border-white/5 rounded-xl overflow-hidden shadow-xl">
            <table class="min-w-full leading-normal text-left">
                <thead>
                <tr class="bg-white/5 text-gray-400 uppercase text-xs font-bold tracking-wider border-b border-white/5">
                    <th class="py-4 px-6">ID</th>
                    <th class="py-4 px-6">Nombre Completo</th>
                    <th class="py-4 px-6">Email</th>
                    <th class="py-4 px-6">Rol</th>
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
                                $esAdmin = $user->role && $user->role->name === 'admin';
                                $clase = $esAdmin ? 'bg-red-500/20 text-red-400 border-red-500/30' : 'bg-blue-500/20 text-blue-400 border-blue-500/30';
                                $rol = $user->role ? $user->role->name : 'Sin Rol';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $clase }}">
                                {{ ucfirst($rol) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
