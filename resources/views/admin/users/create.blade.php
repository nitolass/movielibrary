@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-white font-['Outfit']">Crear <span class="text-yellow-400">Usuario</span></h1>
            <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-white transition-colors">
                &larr; Volver
            </a>
        </div>

        <div class="bg-[#0f1115] border border-white/5 rounded-xl p-8 shadow-xl max-w-2xl mx-auto">
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nombre</label>
                        <input type="text" name="name" class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all placeholder-gray-600" required>
                        @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Apellido</label>
                        <input type="text" name="surname" class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all placeholder-gray-600" required>
                        @error('surname') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Email</label>
                    <input type="email" name="email" class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 outline-none transition-all placeholder-gray-600" required>
                    @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- NOTA: Asumiendo que has añadido password en el controlador, si no, un usuario no puede entrar --}}
                {{-- Si tu controlador genera password aleatoria, puedes omitir esto. Si no, añádelo: --}}
                {{--
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Contraseña</label>
                    <input type="password" name="password" class="w-full bg-[#16181c] border border-gray-700 text-white rounded-xl px-4 py-3 focus:border-yellow-400 outline-none" required>
                </div>
                --}}

                <div class="flex justify-end pt-4 border-t border-white/5">
                    <button type="submit" class="px-8 py-3 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-300 transition-colors shadow-[0_0_15px_rgba(250,204,21,0.4)]">
                        Crear Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
