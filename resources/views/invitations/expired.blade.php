<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Invitación Expirada') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg ">
                <div
                    class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
                    <div class="max-w-md w-full space-y-8">
                        <div class="text-center">
                            <!-- Icono de Reloj/Expirado -->
                            <div
                                class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-red-100 dark:bg-red-900/20">
                                <svg class="h-12 w-12 text-red-600 dark:text-red-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>

                            <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                                Invitación Expirada
                            </h2>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                Lo sentimos, esta invitación ya no es válida
                            </p>
                        </div>

                        <div
                            class="mt-8 bg-white dark:bg-gray-800 py-8 px-6 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-red-500 mt-0.5 mr-3" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                                            Esta invitación ha expirado
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                            Las invitaciones tienen una validez de 7 días. Esta invitación ya no puede
                                            ser utilizada.
                                        </p>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">
                                        ¿Qué puedes hacer?
                                    </h4>
                                    <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-2">
                                        <li class="flex items-start">
                                            <span class="mr-2">•</span>
                                            <span>Contacta a la persona que te invitó para que te envíe una nueva
                                                invitación</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="mr-2">•</span>
                                            <span>Si ya tienes una cuenta, inicia sesión para ver tus planes</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('dashboard') }}"
                                class="flex-1 flex justify-center items-center px-4 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                Ir al inicio
                            </a>

                            @guest
                                <a href="{{ route('login') }}"
                                    class="flex-1 flex justify-center items-center px-4 py-3 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Iniciar sesión
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

