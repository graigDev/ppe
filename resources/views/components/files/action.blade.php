@props(['child'])

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
                @if($child->objectable_type === 'file')
                    <x-dropdown-link  href="{{ route('files.download', $child->objectable) }}">
                        {{ __('Telecharger') }}
                    </x-dropdown-link>
                @endif

                <x-dropdown-link
                    href=""
                    x-on:click.prevent="$dispatch('open-modal', 'file-edit-{{$child->id}}')"
                >
                    {{ __('Renommer') }}
                </x-dropdown-link>
                <x-dropdown-link
                    href=""
                    x-on:click.prevent="$dispatch('open-modal', 'file-details-{{$child->id}}')"
                >
                    {{ __('Details') }}
                </x-dropdown-link>

                @if(auth()->user()->currentRole->slug === 'admin')
                    <x-dropdown-link
                        href=""
                        class="text-red-600"
                        x-on:click.prevent="$dispatch('open-modal', 'file-delete-{{$child->id}}')"
                    >
                        {{ __('Supprimer') }}
                    </x-dropdown-link>
                @endif
            </div>
        </x-slot>
    </x-dropdown>


    {{-- Rename --}}
    <x-modal name="file-edit-{{$child->id}}" :show="Session::has('file-edit-' . $child->id)" maxWidth="xl" focusable>
        <form method="post" action="{{ route('files.update', $child->id) }}" class="p-6" autocomplete="off">
            @csrf
            @method('PUT')
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Renommer
                @if($child->objectable_type === "folder") le dossier @else le fichier @endif
            </h2>

            <div class="my-4">
                <x-input-label for="file-rename-name" :value="$child->objectable_type === 'folder' ? 'Nom du dossier' : 'Nom du fichier' " />
                <x-text-input id="file-rename-name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $child->objectable->name)" autofocus />
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
    <x-modal name="file-details-{{$child->id}}" maxWidth="lg" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Details du') }} {{ $child->objectable_type === 'file' ? 'fichier' : 'dossier' }}
            </h2>

            <div class="my-4 flex flex-col space-y-6">
                <div class="flex">
                    <span class="w-full">Nom</span>
                    <span class="w-full font-semibold inline-block truncate">{{ $child->objectable->name }}</span>
                </div>
                <div class="flex">
                    <span class="w-full">Equipe</span>
                    <span class="w-full font-semibold">{{ $child->team->name }}</span>
                </div>
                <div class="flex">
                    @if($child->objectable_type === 'file')
                        <span class="w-full">Telecharger par</span>
                        <span class="w-full font-semibold">{{ $child->objectable->user->name }}</span>
                    @else
                        <span class="w-full">Créer par</span>
                        <span class="w-full font-semibold">{!!  optional($child->objectable->user)->name ?: "&mdash;" !!}</span>
                    @endif
                </div>
                <div class="flex">
                    <span class="w-full">Modifier</span>
                    <span class="w-full font-semibold">{{ $child->updated_at->format('M d, Y h:i') }}</span>
                </div>
                <div class="flex">
                    <span class="w-full">Télécharger </span>
                    <span class="w-full font-semibold">{{ $child->created_at->format('M d, Y h:i') }}</span>
                </div>
                @if($child->objectable_type === 'file')
                <div class="flex">
                    <span class="w-full">Taille</span>
                    <span class="w-full font-semibold uppercase">{{ $child->objectable->sizeForHumans() }}</span>
                </div>
                @endif
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
        name="file-delete-{{$child->id}}"
        maxWidth="lg"
        :route="route('files.delete', $child->id)"
    >
        <x-slot name="title">
            {{ __('Suppression') }}
        </x-slot>
        <x-slot name="content">
            Etes-vous sûr de vouloir supprimer ce fichier
        </x-slot>
    </x-dialog-modal>
</div>
