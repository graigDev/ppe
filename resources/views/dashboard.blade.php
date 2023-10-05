<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div>
                <h3 class="text-base font-semibold leading-6 text-gray-900">
                    Vue d'ensemble
                </h3>
                <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-4">
                    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Total d'utilisateurs</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $users->count() }}</dd>
                    </div>
                    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Total des équipes</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $teams->count() }}</dd>
                    </div>
                    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Total des dossiers</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $folders->count() }}</dd>
                    </div>
                    <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">Total des fichiers</dt>
                        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ $files->count() }}</dd>
                    </div>
                </dl>
            </div>

        </div>
    </div>
</x-app-layout>
