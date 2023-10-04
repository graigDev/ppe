<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Utilisateurs') }}
        </h2>
    </x-slot>

    <div class="py-8" x-data>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg relative">
                <div>
                    <div class="flex flex-wrap items-center p-4 gap-x-3 gap-y-2 sm:gap-y-0">
                        <form type="get" action="" class="flex-grow order-2 sm:order-1">
                            <x-text-input
                                type="text"
                                name="search"
                                class="w-full"
                                placeholder="Rechercher les utilisateurs"
                                value="{{ Request::get('search') }}"
                            />
                        </form>
                        <div class="space-x-2 order-1 sm:order-2">
                            <x-primary-button type="button" x-on:click.prevent="$dispatch('open-modal', 'user-create')">
                                Nouveau
                            </x-primary-button>
                        </div>
                    </div>

                    <div>
                        <div class="">

                            @if($users->count() > 0)
                                <div>
                                    <table class="w-full">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="text-left py-2 px-4 text-sm font-normal">Nom</th>
                                                <th class="text-left py-2 px-4 text-sm font-normal">Email</th>
                                                <th class="text-left py-2 px-4 text-sm font-normal">Rôle</th>
                                                <th class="text-left py-2 px-4 text-sm font-normal">Equipe</th>
                                                <th class="text-left py-2 px-4 text-sm font-normal">Modifier</th>
                                                <th class="text-left py-2 px-4 text-sm font-normal"></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($users as $user)
                                                <tr class=" {{ !$loop->last ?? 'border-b' }} group border-gray-100 relative border-t">
                                                    <td class="text-sm py-2 px-4">
                                                        <a href="{{ route('users.index', ['uuid' => $user->id]) }}" class="py-2 font-medium group-hover:text-purple-600 flex-grow">
                                                            {{ $user->name }}
                                                        </a>
                                                    </td>
                                                    <td class="text-sm py-2 px-4">
                                                        {{ $user->email }}
                                                    </td>
                                                    <td class="text-sm py-2 px-4">
                                                        {{ "Admin" }}
                                                    </td>
                                                    <td class="text-sm py-2 px-4">
                                                        {{ $user->currentTeam->name }}
                                                    </td>
                                                    <td class="text-sm py-2 px-4">
                                                        {{ $user->updated_at->format('M d, Y h:i') }}
                                                    </td>
                                                    <td class="text-sm py-2 px-4">
                                                       <x-users.action :user="$user"/>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            @if($users->count() === 0)
                                <div class="p-4 text-sm text-center">
                                    Ce espace est vide.
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- New user --}}
        <x-modal name="user-create" :show="Session::has('user-create')" maxWidth="xl" focusable>
            <form method="post" action="{{ route('users.store') }}" class="p-6" autocomplete="off">
                @csrf
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Nouveau utilisateur') }}
                </h2>

                <div class="my-4">
                    <x-input-label for="user-create-name" :value="__('Nom de l\'utilisateur')" />
                    <x-text-input
                        id="user-create-name"
                        class="block mt-1 w-full"
                        type="text"
                        name="name"
                        :value="old('name')"
                        placeholder="Saisir le nom de l'utilisateur"
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="my-4">
                    <x-input-label for="user-create-email" :value="__('Saisir son email')" />
                    <x-text-input
                        id="user-create-email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        placeholder="Saisir le mail de l'utilisateur"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="my-4">
                    <x-input-label for="user-create-email" :value="__('Attribuer un rôle à l\'utilisateur')" />
                    <x-select-input
                        id="user-create-email"
                        class="block mt-1 w-full"
                        name="role"
                    >
                        @foreach($roles as $role)
                            <option {{ old('role') === $role->id ?: 'selected' }} value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <div class="my-4">
                    <x-input-label for="user-create-team" :value="__('Choisir l\'équipe de l\'utilisateur')" />
                    <x-select-input
                        id="user-create-team"
                        class="block mt-1 w-full"
                        name="team"
                    >
                        @foreach($teams as $team)
                            <option {{ old('team') === $team->id ?: 'selected' }} value="{{ $team->id }}">{{ $team->name }}</option>
                        @endforeach
                    </x-select-input>
                    <x-input-error :messages="$errors->get('team')" class="mt-2" />
                </div>

                <div class="my-4">
                    <p class="text-sm text-gray-700">
                        Le mot de passe généré par defaut pour chaque nouveau compte est : <span class="font-medium">password</span>.
                    </p>
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
