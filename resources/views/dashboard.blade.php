<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <x-slot name="headerRight">

        @if (auth()->user()->google_access_token)
            <div class="flex flex-col items-center sm:items-center p-4 mb-4 text-sm text-fg-brand-strong rounded-lg border-4 border-green-500 bg-green-500" role="alert">
             Google Calendar conectado
                <form action="{{ route('google.disconnect') }}" method="POST" class="mt-2 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 ">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">Desconectar</button>
                </form>
            </div>
        @else
            <div class="flex flex-col items-center sm:items-center p-4 mb-4 text-sm text-fg-brand-strong rounded-lg border-4 border-red-500 bg-red-500" role="alert">
                <p class="text-center">Conecta tu Google Calendar
                    <br>
                     para sincronizar planes <br></p>

                <a href="{{ route('google.connect') }}" class="mt-2 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Conectar Google Calendar
                </a>
            </div>
        @endif
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
