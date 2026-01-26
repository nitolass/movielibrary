@extends('layouts.panel')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-white font-['Outfit']">Crear <span class="text-yellow-400">Usuario</span></h1>
            <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-white transition-colors">&larr; Volver</a>
        </div>

        <div class="bg-[#0f1115] border border-white/5 rounded-xl p-8 shadow-xl max-w-2xl mx-auto">
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- NOMBRE Y APELLIDOS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-label for="name" value="Nombre" />
                        <x-input id="name" type="text" name="name" :value="old('name')" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="surname" value="Apellidos" />
                        <x-input id="surname" type="text" name="surname" :value="old('surname')" required />
                        <x-input-error :messages="$errors->get('surname')" class="mt-2" />
                    </div>
                </div>

                {{-- EMAIL Y ROL --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-label for="email" value="Correo Electrónico" />
                        <x-input id="email" type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- ¡¡ESTO ES LO QUE TE FALTABA!! --}}
                    <div>
                        <x-label for="role_id" value="Rol de Usuario" />
                        <select name="role_id" id="role_id" required class="w-full border-gray-700 bg-[#16181c] text-gray-300 focus:border-yellow-400 focus:ring-yellow-400 rounded-md shadow-sm">
                            <option value="" disabled selected>Selecciona un rol...</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                    </div>
                </div>

                {{-- CONTRASEÑAS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-label for="password" value="Contraseña" />
                        <x-input id="password" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="password_confirmation" value="Confirmar Contraseña" />
                        <x-input id="password_confirmation" type="password" name="password_confirmation" required />
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-white/5">
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-gray-800 text-gray-300 font-bold rounded-xl hover:bg-gray-700 transition-colors">Cancelar</a>
                    <button type="submit" class="px-6 py-3 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-500 transition-colors shadow-lg shadow-yellow-400/20">
                        Crear Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
