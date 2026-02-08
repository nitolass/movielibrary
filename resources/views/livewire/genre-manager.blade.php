<div class="container mx-auto px-4 py-6">
    {{-- Cabecera --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white font-['Outfit']">{{ __('Gestión de') }} <span class="text-yellow-400">{{ __('Géneros') }}</span></h1>

        {{-- Buscador y Botón Crear --}}
        <div class="flex gap-4">
            <x-input wire:model.live.debounce.300ms="search" type="text" placeholder="{{ __('Buscar género...') }}" class="w-64" />

            <button wire:click="create()" class="px-5 py-2.5 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-300 shadow-[0_0_15px_rgba(250,204,21,0.4)] transition-all">
                + {{ __('Nuevo') }} {{ __('Género') }}
            </button>
        </div>
    </div>

    {{-- Mensajes Flash --}}
    @if (session()->has('message'))
        <div class="bg-green-500/20 text-green-400 p-4 rounded-xl mb-6 border border-green-500/50">
            {{ __(session('message')) }}
        </div>
    @endif

    {{-- Tabla --}}
    <div class="bg-[#0f1115] border border-white/5 rounded-xl overflow-hidden shadow-xl">
        <table class="min-w-full leading-normal text-left">
            <thead>
            <tr class="bg-white/5 text-gray-400 uppercase text-xs font-bold tracking-wider border-b border-white/5">
                <th class="py-4 px-6">ID</th>
                <th class="py-4 px-6">{{ __('Nombre') }}</th>
                <th class="py-4 px-6">{{ __('Descripción') }}</th>
                <th class="py-4 px-6 text-center">{{ __('Acciones') }}</th>
            </tr>
            </thead>
            <tbody class="text-gray-300 text-sm">
            @foreach($genres as $genre)
                <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                    <td class="py-4 px-6 font-mono text-xs text-gray-500">{{ $genre->id }}</td>
                    <td class="py-4 px-6 font-bold text-white">{{ $genre->name }}</td>
                    <td class="py-4 px-6 text-gray-400">{{ Str::limit($genre->description, 50) }}</td>
                    <td class="py-4 px-6 flex justify-center gap-2">

                        {{-- Botón Editar --}}
                        <button wire:click="edit({{ $genre->id }})" class="p-2 bg-gray-800 text-blue-400 rounded-lg hover:bg-blue-600 hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>

                        {{-- Botón Eliminar --}}
                        <button wire:click="delete({{ $genre->id }})" wire:confirm="{{ __('¿Estás seguro de eliminar?') }} {{ $genre->name }}?" class="p-2 bg-gray-800 text-red-400 rounded-lg hover:bg-red-600 hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Paginación --}}
        <div class="px-6 py-4">
            {{ $genres->links() }}
        </div>
    </div>

    {{-- MODAL (Formulario Create/Edit) --}}
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-70 backdrop-blur-sm">
            <div class="bg-[#1a1d24] border border-white/10 text-white rounded-xl shadow-2xl w-full max-w-lg p-6 relative">

                {{-- Título Modal --}}
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold font-['Outfit']">
                        {{ $genreId ? __('Editar') . ' ' . __('Género') : __('Crear') . ' ' . __('Nuevo') . ' ' . __('Género') }}
                    </h2>
                    <button wire:click="closeModal()" class="text-gray-400 hover:text-white">&times;</button>
                </div>

                {{-- Formulario --}}
                <form wire:submit.prevent="{{ $genreId ? 'update' : 'store' }}" class="space-y-6">

                    {{-- Campo Nombre --}}
                    <div>
                        <x-label for="name" :value="__('Nombre del Género')" />
                        <x-input id="name" type="text" wire:model="name" class="w-full mt-1" placeholder="{{ __('Ej: Ciencia Ficción') }}" />
                        @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Campo Descripción --}}
                    <div>
                        <x-label for="description" :value="__('Descripción (Opcional)')" />
                        <x-textarea id="description" wire:model="description" rows="3" class="w-full mt-1"></x-textarea>
                        @error('description') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Botones Footer --}}
                    <div class="flex justify-end gap-4 pt-4 border-t border-white/5">
                        <button type="button" wire:click="closeModal()" class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition">
                            {{ __('Cancelar') }}
                        </button>
                        <button type="submit" class="px-4 py-2 bg-yellow-400 text-black font-bold rounded-lg hover:bg-yellow-300 shadow-lg transition">
                            {{ $genreId ? __('Actualizar') : __('Guardar') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
