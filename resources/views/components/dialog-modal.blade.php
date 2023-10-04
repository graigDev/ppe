@props([
    'name'  =>  '',
    'maxWidth'  =>  'lg',
    'route' =>  ''
])


<x-modal :name="$name" :maxWidth="$maxWidth" focusable>
    <form action="{{ $route }}" method="post" class="p-6" autocomplete="off">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
            {{ $title }}
        </h2>

        <div class="text-sm text-gray-700">
            {{ $content }}
        </div>

        <div class="mt-6 flex justify-between items-center">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Annuler') }}
            </x-secondary-button>
            <x-danger-button class="ml-3">
                {{ __('Supprimer') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
