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

                <div>
                    <x-label for="email" value="Correo Electrónico" />
                    <x-input id="email" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-label for="password" value="Contraseña" />
                        <x-input id="password" type="password" name="password" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="password_confirmation" value="Confirmar Contraseña" />
                        <x-input id="password_confirmation" type="password" name="password_confirmation" required />
                    </div>
                </div>



                <div class="flex justify-end gap-4 pt-4 border-t border-white/5">
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-gray-800 text-gray-300 font-bold rounded-xl hover:bg-gray-700 transition-colors">Cancelar</a>
                    <x-button>Crear Usuario</x-button>
                </div>
            </form>
        </div>
    </div>
@endsection
