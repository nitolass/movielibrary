<x-app-layout>
    <x-slot name="header">
        <h2 class="font-['Outfit'] font-black text-3xl text-white leading-tight drop-shadow-md">
            Gestión de <span class="text-yellow-400">Perfil</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @include('profile.partials.update-profile-information-form')

            @include('profile.partials.update-password-form')

            @include('profile.partials.delete-user-form')

        </div>
    </div>
</x-app-layout>
