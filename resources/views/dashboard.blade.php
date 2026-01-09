<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div
                    class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">

                    <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                        Calendarios de planes
                    </h1>

                    <p class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
                        Visualizacion de los planes programados en un calendario interactivo.

                        <span>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Id ab quod obcaecati, pariatur
                            esse nam reprehenderit explicabo aliquam natus sit.
                        </span>
                    </p>
                </div>

                <div class="w-full bg-gray-200 dark:bg-gray-800 bg-opacity-25  gap-6 lg:gap-8 p-6 lg:p-8">

                    @livewire('calendar-plan')



                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div
                    class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">

                    <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                        Lista de planes Creados
                    </h1>

                    <p class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
                        Aquí puedes ver todos los planes que has creado en el sistema. Puedes editar o eliminar
                        cualquier plan según tus necesidades.

                        <span>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Id ab quod obcaecati, pariatur
                            esse nam reprehenderit explicabo aliquam natus sit.
                        </span>
                    </p>
                </div>

                <div class="w-full bg-gray-200 dark:bg-gray-800 bg-opacity-25  gap-6 lg:gap-8 p-6 lg:p-8">

                    @livewire('list-plan')



                </div>
            </div>
        </div>
    </div>


</x-app-layout>
