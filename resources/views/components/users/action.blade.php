@props(['user'])

<div x-data class="flex justify-end items-center">
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <button class="p-2 rounded-lg hover:bg-gray-50 focus:bg-gray-50">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
            </button>
        </x-slot>
        <x-slot name="content">
            <div class="divide-y">
                <x-dropdown-link
                    href=""
                    x-on:click.prevent="$dispatch('open-modal', 'user-edit-{{$user->id}}')"
                >
                    {{ __('Modifier') }}
                </x-dropdown-link>
                <x-dropdown-link
                    href=""
                    x-on:click.prevent="$dispatch('open-modal', 'user-details-{{$user->id}}')"
                >
                    {{ __('Details') }}
                </x-dropdown-link>
                <x-dropdown-link
                    href=""
                    class="text-red-600"
                    x-on:click.prevent="$dispatch('open-modal', 'user-delete-{{$user->id}}')"
                >
                    {{ __('Supprimer') }}
                </x-dropdown-link>
            </div>
        </x-slot>
    </x-dropdown>


    {{-- edit --}}
    <x-modal name="user-edit-{{$user->id}}" :show="Session::has('user-edit-' . $user->id)" maxWidth="xl" focusable>
        <form method="post" action="{{ route('users.update', $user->id) }}" class="p-6" autocomplete="off">
            @csrf
            @method('PUT')
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Modifier l'utilisateur
            </h2>

            <div class="my-4">
                <x-input-label for="user-rename-name" value="Nom de l'utilisateur" />
                <x-text-input id="user-rename-name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-6 flex items-center justify-between">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Annuler') }}
                </x-secondary-button>
                <x-primary-button class="ml-3">
                    {{ __('Enregistrer') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>


    {{-- Details --}}
    <x-modal name="user-details-{{$user->id}}" maxWidth="lg" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __("Details sur l'utilisateur") }}
            </h2>

            <div class="my-4 flex flex-col space-y-6">
                <div class="flex">
                    <span class="w-full">Nom</span>
                    <span class="w-full font-semibold">{{ $user->name }}</span>
                </div>
                <div class="flex">
                    <span class="w-full">Email</span>
                    <span class="w-full font-semibold">{{ $user->email }}</span>
                </div>
                <div class="flex">
                    <span class="w-full">Equipe</span>
                    <span class="w-full font-semibold">{{ $user->currentTeam->name }}</span>
                </div>
                <div class="flex">
                    <span class="w-full">Rôle</span>
                    <span class="w-full font-semibold">{{ $user->currentRole->name }}</span>
                </div>
                <div class="flex">
                    <span class="w-full">Créer</span>
                    <span class="w-full font-semibold">{{ $user->created_at->format('M d, Y h:i') }}</span>
                </div>

            </div>

            <div class="mt-6 flex justify-between">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Fermer') }}
                </x-secondary-button>

            </div>
        </div>
    </x-modal>


    {{-- Delete --}}
    <x-dialog-modal
        name="user-delete-{{$user->id}}"
        maxWidth="lg"
        :route="route('users.delete', $user->id)"
    >
        <x-slot name="title">
            {{ __('Suppression') }}
        </x-slot>
        <x-slot name="content">
            Etes-vous sûr de vouloir supprimer l'equipe <span class="font-medium">"{{ $user->name }}"</span> ?
            Sa suppression entrenera la perte totale de ces dossiers et fichiers.
        </x-slot>
    </x-dialog-modal>
</div>
