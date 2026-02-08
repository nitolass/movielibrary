<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Editar Reseña') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#16181c] border border-white/5 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-6">
                    <h3 class="text-lg font-bold text-white">
                        {{ __('Película') }}: <span class="text-yellow-400">{{ $review->movie->title }}</span>
                    </h3>
                </div>

                <form method="POST" action="{{ route('reviews.update', $review) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="rating" :value="__('Puntuación')" class="text-gray-300" />

                        <x-select id="rating" name="rating" class="mt-1 block w-full">
                            <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5) - {{ __('Excelente') }}</option>
                            <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4) - {{ __('Muy buena') }}</option>
                            <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>⭐⭐⭐ (3) - {{ __('Normal') }}</option>
                            <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>⭐⭐ (2) - {{ __('Mala') }}</option>
                            <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>⭐ (1) - {{ __('Terrible') }}</option>
                        </x-select>
                        <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="content" :value="__('Tu opinión')" class="text-gray-300" />

                        <x-textarea id="content" name="content" rows="4" class="mt-1 block w-full" required>
                            {{ old('content', $review->content) }}
                        </x-textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    {{-- Checkbox de Spoilers (Opcional si lo tienes en tu DB, si no, puedes quitarlo) --}}
                    {{--
                    <div class="block">
                        <label for="spoilers" class="inline-flex items-center">
                            <x-checkbox id="spoilers" name="spoilers" value="1" :checked="$review->spoilers" />
                            <span class="ml-2 text-sm text-gray-400">{{ __('Esta reseña contiene Spoilers') }}</span>
                        </label>
                    </div>
                    --}}

                    <div class="flex items-center justify-end gap-4 mt-4">
                        <a href="{{ route('user.movies.show', $review->movie_id) }}" class="text-sm text-gray-400 hover:text-white underline">
                            {{ __('Cancelar') }}
                        </a>

                        <x-primary-button class="bg-yellow-400 text-black hover:bg-yellow-500 font-bold border-none">
                            {{ __('Actualizar Reseña') }}
                        </x-primary-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
