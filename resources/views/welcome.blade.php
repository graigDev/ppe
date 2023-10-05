<x-app-layout>

    <section>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative flex w-full flex-col items-center justify-center text-center">
                <div class="w-full max-w-lg self-center md:w-3/5 lg:max-w-lg">
                    <div class="py-5 text-sm md:text-xl">
                        <p>{{ config('app.name') }}, c'est la vie privée pour tous</p>
                    </div>
                </div>
                <div class="max-w-xl">
                    <h1 class="px-5 text-3xl leading-none md:px-0 lg:text-3xl">
                        <span class="font-light">
                            Un systeme d'archivage de documents privé, où
                        </span>
                         la vie privée et la liberté passent avant tout.
                    </h1>
                </div>
            </div>

            <div class="px-4 sm:px-0">
                <div class="my-6 border max-w-5xl rounded-xl mx-auto overflow-hidden">
                    <img src="{{ asset('images/files.png') }}" class="w-full" alt="">
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
