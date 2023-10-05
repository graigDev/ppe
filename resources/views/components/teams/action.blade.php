@props(['team'])

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
                    x-on:click.prevent="$dispatch('open-modal', 'team-edit-{{$team->id}}')"
                >
                    {{ __('Renommer') }}
                </x-dropdown-link>
                <x-dropdown-link
                    href=""
                    x-on:click.prevent="$dispatch('open-modal', 'team-details-{{$team->id}}')"
                >
                    {{ __('Details') }}
                </x-dropdown-link>

                @if(auth()->user()->currentRole->slug === 'admin')
                    <x-dropdown-link
                        href=""
                        class="text-red-600"
                        x-on:click.prevent="$dispatch('open-modal', 'team-delete-{{$team->id}}')"
                    >
                        {{ __('Supprimer') }}
                    </x-dropdown-link>
                @endif
            </div>
        </x-slot>
    </x-dropdown>


    {{-- Rename --}}
    <x-modal name="team-edit-{{$team->id}}" :show="Session::has('team-edit-' . $team->id)" maxWidth="xl" focusable>
        <form method="post" action="{{ route('teams.update', $team->id) }}" class="p-6" autocomplete="off">
            @csrf
            @method('PUT')
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Renommer l'equipe
            </h2>

            <div class="my-4">
                <x-input-label for="team-rename-name" value="Nom de l'quipe" />
                <x-text-input id="team-rename-name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $team->name)" autofocus />
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
    <x-modal name="team-details-{{$team->id}}" maxWidth="lg" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __("Details sur l'equipe") }}
            </h2>

            <div class="my-4 flex flex-col space-y-6">
                <div class="flex">
                    <span class="w-full">Nom</span>
                    <span class="w-full font-semibold">{{ $team->name }}</span>
                </div>
                <div class="flex">
                    <span class="w-full">Créer par</span>
                    <span class="w-full font-semibold">{{ $team->user->name }}</span>
                </div>
                <div class="flex">
                    <span class="w-full">Modifier</span>
                    <span class="w-full font-semibold">{{ $team->updated_at->format('M d, Y h:i') }}</span>
                </div>
                <div class="flex">
                    <span class="w-full">Créer</span>
                    <span class="w-full font-semibold">{{ $team->created_at->format('M d, Y h:i') }}</span>
                </div>
                <div class="flex">
                    <span class="w-full">Membres</span>
                    <span class="w-full font-semibold">{{ $team->users()->count() }}</span>
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
        name="team-delete-{{$team->id}}"
        maxWidth="lg"
        :route="route('teams.delete', $team->id)"
    >
        <x-slot name="title">
            {{ __('Suppression') }}
        </x-slot>
        <x-slot name="content">
            Etes-vous sûr de vouloir supprimer l'equipe <span class="font-medium">"{{ $team->name }}"</span> ?
            Sa suppression entrenera la perte totale de ces dossiers et fichiers.
        </x-slot>
    </x-dialog-modal>
</div>
