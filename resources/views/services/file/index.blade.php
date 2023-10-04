<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Fichiers') }}
        </h2>
    </x-slot>

    <div class="py-8" x-data>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg relative">
                <div>
                    <div class="flex flex-wrap items-center px-4 pt-4 pb-2 gap-x-3 gap-y-2 sm:gap-y-0">
                        <form type="get" action="" class="flex-grow order-2 sm:order-1" autocomplete="off">
                            <x-text-input
                                type="text"
                                name="search"
                                class="w-full"
                                value="{{ Request::get('search') }}"
                                placeholder="Rechercher des fichiers ou dossiers"
                            />
                        </form>
                        <div class="space-x-2 order-1 sm:order-2">

                            @if(Request::get('search'))
                                <x-secondary-link href="{{ request()->fullUrlWithoutQuery(['search']) }}">
                                    X
                                </x-secondary-link>
                            @else
                                <x-secondary-button type="button" x-on:click.prevent="$dispatch('open-modal', 'folder-create')">
                                    Nouveau dossier
                                </x-secondary-button>
                                <x-primary-button type="button" x-on:click.prevent="$dispatch('open-modal', 'uploader')">
                                    Televerser
                                </x-primary-button>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="">
                                <div class="py-2 px-4">
                                    @if(!Request::get('search'))
                                    <div class="flex items-center text-sm text-gray-500">
                                        @foreach($ancestors as $ancestor)
                                            <a href="{{ route('files.index', ['uuid' => $ancestor->uuid]) }}">{{ $ancestor->objectable->name }}</a>

                                            @if(!$loop->last)
                                                <span>
                                                    <svg class="w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                                    </svg>
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                    @else
                                        <span class="text-sm text-gray-700">
                                            {{ $results->count() }} {{ Str::plural('resultat', $results->count()) }} {{ Str::plural('trouvé', $results->count()) }}.
                                        </span>
                                    @endif
                                </div>

                            @if($results->count() > 0)
                                <div>
                                    <table class="w-full">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="text-left py-2 px-4 text-sm font-normal">Nom</th>
                                                <th class="text-left py-2 px-4 text-sm font-normal">Modifier</th>
                                                <th class="text-left py-2 px-4 text-sm font-normal">Taille</th>
                                                <th class="text-left py-2 px-4 text-sm font-normal"></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($results as $child)
                                                <tr class=" {{ !$loop->last ?? 'border-b' }} group border-gray-100 relative border-t">
                                                    <td class="text-sm py-2 px-4">

                                                        <div class="flex items-center space-x-2">
                                                            {{-- folder --}}
                                                            @if($child->objectable_type === 'folder')
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 fill-purple-600">
                                                                        <path d="M19.5 21a3 3 0 003-3v-4.5a3 3 0 00-3-3h-15a3 3 0 00-3 3V18a3 3 0 003 3h15zM1.5 10.146V6a3 3 0 013-3h5.379a2.25 2.25 0 011.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 013 3v1.146A4.483 4.483 0 0019.5 9h-15a4.483 4.483 0 00-3 1.146z" />
                                                                    </svg>
                                                                </span>
                                                            @endif

                                                            {{-- file --}}
                                                            @if($child->objectable_type === 'file')
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 fill-purple-600">
                                                                        <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625z" />
                                                                        <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z" />
                                                                    </svg>
                                                                </span>
                                                            @endif


                                                            @if($child->objectable_type === 'folder')
                                                                <a href="{{ route('files.index', ['uuid' => $child->uuid]) }}" class="py-2 font-medium group-hover:text-purple-600 flex-grow">
                                                                    {{ $child->objectable->name }}
                                                                </a>
                                                            @else
                                                                <span class="whitespace-nowrap truncate">
                                                                    {{ $child->objectable->name }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-sm py-2 px-4">
                                                        {{ $child->updated_at->format('M d, Y h:i') }}
                                                    </td>
                                                    <td class="text-sm py-2 px-4 uppercase">
                                                        @if($child->objectable_type === 'folder')
                                                            &mdash;
                                                        @else
                                                            {{ $child->objectable->sizeForHumans() }}
                                                        @endif
                                                    </td>
                                                    <td class="text-sm py-2 px-4">
                                                       <x-files.action :child="$child"/>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            @if($results->count() === 0)
                                <div class="p-4 text-sm text-center">
                                    Ce dossier est vide.
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(!Request::get('search'))

        {{-- New folder --}}
        <x-modal name="folder-create" :show="Session::has('folder-create')" maxWidth="xl" focusable>
            <form method="post" action="{{ route('files.store', $object->id) }}" class="p-6" autocomplete="off">
                @csrf
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Nouveau dossier') }}
                </h2>

                <div class="my-4">
                    <x-input-label for="folder-create-name" :value="__('Nom du dossier')" />
                    <x-text-input
                        id="folder-create-name"
                        class="block mt-1 w-full"
                        type="text"
                        name="name"
                        :value="old('name')"
                        placeholder="Saisir le nom du dossier"
                        autofocus
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-6 flex">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Annuler') }}
                    </x-secondary-button>
                    <x-primary-button class="ml-3">
                        {{ __('Créer') }}
                    </x-primary-button>
                </div>
            </form>
        </x-modal>


        {{-- Uploader --}}
        <x-modal name="uploader" :show="Session::has('uploader')" maxWidth="xl" focusable>
            <div class="p-6">

                <div>
                    <x-filepond :server="route('files.upload', $object->id)" size="100MB" max="6"/>
                </div>

                <div class="mt-6 flex">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Annuler') }}
                    </x-secondary-button>
                </div>
            </div>
        </x-modal>

        @endif

    </div>

</x-app-layout>
