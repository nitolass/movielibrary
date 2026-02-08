<div class="container mx-auto px-4 py-6">

    {{-- Cabecera --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white font-['Outfit']">{{ __('Gestión de') }} <span class="text-yellow-400">{{ __('Actores') }}</span></h1>

        <div class="flex gap-4">
            <x-input wire:model.live.debounce.300ms="search" type="text" placeholder="{{ __('Buscar actor...') }}" class="w-64" />

            <button wire:click="create()" class="px-5 py-2.5 bg-yellow-400 text-black font-bold rounded-xl hover:bg-yellow-300 shadow-[0_0_15px_rgba(250,204,21,0.4)] transition-all">
                + {{ __('Nuevo') }} {{ __('Actor') }}
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
                <th class="py-4 px-6">{{ __('Foto') }}</th>
                <th class="py-4 px-6">{{ __('Nombre') }}</th>
                <th class="py-4 px-6">{{ __('Año Nac.') }}</th>
                <th class="py-4 px-6">{{ __('Nacionalidad') }}</th>
                <th class="py-4 px-6 text-center">{{ __('Acciones') }}</th>
            </tr>
            </thead>
            <tbody class="text-gray-300 text-sm">
            @foreach($actors as $actor)
                <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                    <td class="py-4 px-6 font-mono text-xs text-gray-500">{{ $actor->id }}</td>
                    <td class="py-4 px-6">
                        @if($actor->photo)
                            <img src="{{ asset('storage/' . $actor->photo) }}" class="h-10 w-10 rounded-full object-cover border border-gray-600">
                        @else
                            <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center text-xs">N/A</div>
                        @endif
                    </td>
                    <td class="py-4 px-6 font-bold text-white">{{ $actor->name }}</td>
                    <td class="py-4 px-6">{{ $actor->birth_year }}</td>
                    <td class="py-4 px-6">{{ $actor->nationality ?? '-' }}</td>
                    <td class="py-4 px-6 flex justify-center gap-2">
                        <button wire:click="edit({{ $actor->id }})" class="p-2 bg-gray-800 text-blue-400 rounded-lg hover:bg-blue-600 hover:text-white transition-all">
                            {{ __('Editar') }}
                        </button>
                        {{-- Confirmación traducida --}}
                        <button wire:click="delete({{ $actor->id }})" wire:confirm="{{ __('¿Estás seguro de eliminar?') }} {{ $actor->name }}?" class="p-2 bg-gray-800 text-red-400 rounded-lg hover:bg-red-600 hover:text-white transition-all">
                            {{ __('Eliminar') }}
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $actors->links() }}
        </div>
    </div>

    {{-- MODAL --}}
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-70 backdrop-blur-sm">
            <div class="bg-[#1a1d24] border border-white/10 text-white rounded-xl shadow-2xl w-full max-w-2xl p-8 relative max-h-[90vh] overflow-y-auto">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold font-['Outfit']">
                        {{ $actorId ? __('Editar') . ' ' . __('Actor') : __('Crear') . ' ' . __('Nuevo') . ' ' . __('Actor') }}
                    </h2>
                    <button wire:click="closeModal()" class="text-gray-400 hover:text-white">&times;</button>
                </div>

                <form wire:submit.prevent="{{ $actorId ? 'update' : 'store' }}" class="space-y-6">

                    {{-- Nombre --}}
                    <div>
                        <x-label for="name" :value="__('Nombre Completo')" />
                        <x-input id="name" type="text" wire:model="name" class="w-full mt-1" />
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Biografía --}}
                    <div>
                        <x-label for="biography" :value="__('Biografía')" />
                        <x-textarea id="biography" wire:model="biography" rows="3" class="w-full mt-1"></x-textarea>
                        @error('biography') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Grid: Año y Nacionalidad --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-label for="birth_year" :value="__('Año de Nacimiento')" />
                            <x-input id="birth_year" type="number" wire:model="birth_year" class="w-full mt-1" />
                            @error('birth_year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-label for="nationality" :value="__('Nacionalidad')" />
                            <x-input id="nationality" type="text" wire:model="nationality" class="w-full mt-1" />
                            @error('nationality') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- FOTO --}}
                    <div>
                        <x-label for="photo" :value="__('Fotografía')" />

                        {{-- Previsualización --}}
                        <div class="mt-2 mb-4 flex gap-4 items-center">
                            @if ($photo)
                                <div class="text-center">
                                    <span class="block text-xs text-gray-400 mb-1">{{ __('Nueva') }}:</span>
                                    <img src="{{ $photo->temporaryUrl() }}" class="h-20 w-20 object-cover rounded-lg border border-yellow-400">
                                </div>
                            @elseif ($existingPhoto)
                                <div class="text-center">
                                    <span class="block text-xs text-gray-400 mb-1">{{ __('Actual') }}:</span>
                                    <img src="{{ asset('storage/' . $existingPhoto) }}" class="h-20 w-20 object-cover rounded-lg border border-gray-600">
                                </div>
                            @endif
                        </div>

                        <input type="file" wire:model="photo" id="photo" class="block w-full text-sm text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-gray-800 file:text-yellow-400
                            hover:file:bg-gray-700
                        "/>
                        <div wire:loading wire:target="photo" class="text-sm text-yellow-400 mt-1">{{ __('Subiendo imagen...') }}</div>
                        @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Botones --}}
                    <div class="flex justify-end gap-4 pt-4 border-t border-white/5">
                        <button type="button" wire:click="closeModal()" class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition">{{ __('Cancelar') }}</button>
                        <button type="submit" class="px-4 py-2 bg-yellow-400 text-black font-bold rounded-lg hover:bg-yellow-300 shadow-lg transition">
                            {{ $actorId ? __('Actualizar') : __('Guardar') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
