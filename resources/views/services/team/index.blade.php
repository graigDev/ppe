<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Equipe') }}
        </h2>
    </x-slot>

    <div class="py-8" x-data>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg relative">
                <div>
                    <div class="flex flex-wrap items-center p-4 gap-x-3 gap-y-2 sm:gap-y-0">
                        <form type="get" action="" class="flex-grow order-2 sm:order-1" autocomplete="off">
                            <x-text-input
                                type="text"
                                class="w-full"
                                name="search"
                                value="{{ Request::get('search') }}"
                                placeholder="Rechercher l'équipe"
                            />
                        </form>
                        <div class="space-x-2 order-1 sm:order-2">
                            @if(Request::get('search'))
                                <x-secondary-link href="{{ request()->fullUrlWithoutQuery(['search']) }}">
                                    X
                                </x-secondary-link>
                            @else
                                <x-primary-button type="button" x-on:click.prevent="$dispatch('open-modal', 'team-create')">
                                    Nouvelle
                                </x-primary-button>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="">

                            @if($teams->count() > 0)
                                <div>
                                    <table class="w-full">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="text-left py-2 px-4 text-sm font-normal">Nom</th>
                                                <th class="text-left py-2 px-4 text-sm font-normal">Dossiers</th>
                                                <th class="text-left py-2 px-4 text-sm font-normal">Fichiers</th>
                                                <th class="text-left py-2 px-4 text-sm font-normal">Membre</th>
                                                <th class="text-left py-2 px-4 text-sm font-normal">Modifier</th>
                                                <th class="text-left py-2 px-4 text-sm font-normal"></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($teams as $team)
                                                <tr class=" {{ !$loop->last ?? 'border-b' }} group border-gray-100 relative border-t">
                                                    <td class="text-sm py-2 px-4">
                                                        <a href="{{ route('teams.index', ['uuid' => $team->id]) }}" class="py-2 font-medium group-hover:text-purple-600 flex-grow">
                                                            {{ $team->name }}
                                                        </a>
                                                    </td>
                                                    <td class="text-sm py-2 px-4 uppercase">
                                                        {{ $team->folders->count() }}
                                                    </td>
                                                    <td class="text-sm py-2 px-4 uppercase">
                                                        {{ $team->files->count() }}
                                                    </td>
                                                    <td class="text-sm py-2 px-4 uppercase">
                                                        {{ $team->users()->count() }}
                                                    </td>
                                                    <td class="text-sm py-2 px-4">
                                                        {{ $team->updated_at->format('M d, Y h:i') }}
                                                    </td>
                                                    <td class="text-sm py-2 px-4">
                                                       <x-teams.action :team="$team"/>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            @if($teams->count() === 0)
                                <div class="p-4 text-sm text-center">
                                    Ce espace est vide.
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- New team --}}
        <x-modal name="team-create" :show="Session::has('team-create')" maxWidth="xl" focusable>
            <form method="post" action="{{ route('teams.store') }}" class="p-6" autocomplete="off">
                @csrf
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Nouvelle equipe') }}
                </h2>

                <div class="my-4">
                    <x-input-label for="team-create-name" :value="__('Nom de l\'équipe')" />
                    <x-text-input
                        id="team-create-name"
                        class="block mt-1 w-full"
                        type="text"
                        name="name"
                        :value="old('name')"
                        placeholder="Saisir le nom de l'équipe"
                        autofocus
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-between items-center">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Annuler') }}
                    </x-secondary-button>
                    <x-primary-button class="ml-3">
                        {{ __('Créer') }}
                    </x-primary-button>
                </div>
            </form>
        </x-modal>
    </div>

</x-app-layout>
