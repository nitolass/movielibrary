<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white font-['Outfit']">{{ __('Gestión de') }} <span class="text-yellow-400">{{ __('Usuarios') }}</span></h1>

        <div class="flex items-center gap-4">
            {{-- Botón PDF Global --}}
            <a href="{{ route('admin.pdf.users') }}" target="_blank" class="flex items-center gap-2 bg-red-600/20 text-red-400 border border-red-500/30 hover:bg-red-600 hover:text-white px-4 py-2 rounded-xl text-sm transition-all">
                <span>{{ __('PDF Lista') }}</span>
            </a>

            {{-- Buscador y Crear --}}
            <x-input wire:model.live.debounce.300ms="search" type="text" placeholder="{{ __('Buscar usuario...') }}" class="w-48" />
            <button wire:click="create()" class="px-5 py-2.5 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-300 shadow-[0_0_15px_rgba(250,204,21,0.4)] transition-all">
                + {{ __('Nuevo') }}
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-500/20 text-green-400 p-4 rounded-xl mb-6 border border-green-500/50">
            {{ __(session('message')) }}
        </div>
    @endif

    <div class="bg-[#0f1115] border border-white/5 rounded-xl overflow-hidden shadow-xl">
        <table class="min-w-full leading-normal text-left">
            <thead>
            <tr class="bg-white/5 text-gray-400 uppercase text-xs font-bold tracking-wider border-b border-white/5">
                <th class="py-4 px-6">ID</th>
                <th class="py-4 px-6">{{ __('Nombre') }}</th>
                <th class="py-4 px-6">{{ __('Email') }}</th>
                <th class="py-4 px-6">{{ __('Rol') }}</th>
                <th class="py-4 px-6 text-center">{{ __('Acciones') }}</th>
            </tr>
            </thead>
            <tbody class="text-gray-300 text-sm">
            @foreach($users as $user)
                <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                    <td class="py-4 px-6 font-mono text-xs text-gray-500">{{ $user->id }}</td>
                    <td class="py-4 px-6 font-bold text-white">{{ $user->name }} {{ $user->surname }}</td>
                    <td class="py-4 px-6">{{ $user->email }}</td>
                    <td class="py-4 px-6">
                            <span class="px-3 py-1 rounded-full text-xs font-bold border
                                {{ optional($user->role)->name === 'admin' ? 'bg-red-500/20 text-red-400 border-red-500/30' : 'bg-blue-500/20 text-blue-400 border-blue-500/30' }}">
                                {{ __(ucfirst(optional($user->role)->name ?? 'Sin Rol')) }}
                            </span>
                    </td>
                    <td class="py-4 px-6 flex justify-center gap-2 items-center">
                        {{-- Ver Detalle --}}
                        <a href="{{ route('admin.users.show', $user->id) }}" class="text-gray-400 hover:text-white mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </a>

                        <button wire:click="edit({{ $user->id }})" class="text-blue-400 hover:text-blue-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </button>

                        <button wire:click="delete({{ $user->id }})" wire:confirm="{{ __('¿Estás seguro de eliminar?') }}" class="text-red-400 hover:text-red-300 ml-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $users->links() }}</div>
    </div>

    {{-- MODAL --}}
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm">
            <div class="bg-[#1a1d24] border border-white/10 text-white rounded-xl shadow-2xl w-full max-w-2xl p-8">
                <div class="flex justify-between mb-6">
                    <h2 class="text-2xl font-bold">{{ $userId ? __('Editar') . ' ' . __('Usuario') : __('Crear') . ' ' . __('Usuario') }}</h2>
                    <button wire:click="closeModal()" class="text-gray-400 hover:text-white">&times;</button>
                </div>

                <form wire:submit.prevent="{{ $userId ? 'update' : 'store' }}" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-label for="name" :value="__('Nombre')" />
                            <x-input wire:model="name" id="name" class="w-full mt-1" />
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-label for="surname" :value="__('Apellidos')" />
                            <x-input wire:model="surname" id="surname" class="w-full mt-1" />
                            @error('surname') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-label for="email" :value="__('Email')" />
                            <x-input wire:model="email" id="email" type="email" class="w-full mt-1" />
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- USO DE COMPONENTE SELECT --}}
                        <div>
                            <x-label for="role_id" :value="__('Rol')" />
                            <x-select wire:model="role_id" id="role_id" class="w-full mt-1">
                                <option value="" disabled>{{ __('Selecciona un rol...') }}</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ __(ucfirst($role->name)) }}</option>
                                @endforeach
                            </x-select>
                            @error('role_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- PASSWORD (Opcional en edición) --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-label for="password" :value="__('Contraseña') . ($userId ? ' (' . __('Opcional') . ')' : '')" />
                            <x-input wire:model="password" type="password" class="w-full mt-1" />
                            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                            <x-input wire:model="password_confirmation" type="password" class="w-full mt-1" />
                        </div>
                    </div>

                    {{-- USO DE COMPONENTE CHECKBOX --}}
                    <div class="block mt-4">
                        <label for="verified" class="flex items-center">
                            <x-checkbox wire:model="verified" id="verified" />
                            <span class="ml-2 text-sm text-gray-400">{{ __('Verificar cuenta') }} ({{ __('Email verificado') }})</span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-4 pt-4 border-t border-white/5">
                        <button type="button" wire:click="closeModal()" class="px-4 py-2 bg-gray-700 rounded-lg">{{ __('Cancelar') }}</button>
                        <button type="submit" class="px-4 py-2 bg-yellow-400 text-black font-bold rounded-lg shadow-lg">
                            {{ $userId ? __('Actualizar') : __('Guardar') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
