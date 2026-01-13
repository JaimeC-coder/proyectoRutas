<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registro') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg ">

                <div
                    class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
                    <div class="max-w-2xl w-full space-y-8">
                        <!-- Header -->
                        <div class="text-center">
                            <div
                                class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-indigo-100 dark:bg-indigo-900/20">
                                <svg class="h-12 w-12 text-indigo-600 dark:text-indigo-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                    </path>
                                </svg>
                            </div>

                            <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                                ¡Has sido invitado!
                            </h2>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                Crea tu cuenta para unirte al plan
                            </p>
                        </div>

                        <!-- Plan Info Card -->
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                            <h3 class="text-xl font-bold mb-2">{{ $invitation->plan->name }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($invitation->plan->date)->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $invitation->plan->time_out }}</span>
                                </div>
                                <div class="flex items-center md:col-span-2">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>{{ $invitation->plan->meeting_place }}</span>
                                </div>
                            </div>

                            @if ($invitation->plan->description)
                                <div class="mt-4 pt-4 border-t border-white/20">
                                    <p class="text-sm opacity-90">{{ $invitation->plan->description }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Registration Form -->
                        <div
                            class="bg-white dark:bg-gray-800 py-8 px-6 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700">
                            <form method="POST" action="{{ route('invitation.register', $invitation->token) }}"
                                class="space-y-6">
                                @csrf

                                <!-- Email (readonly) -->
                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Correo electrónico
                                    </label>
                                    <input type="email" id="email" value="{{ $invitation->email }}" readonly
                                        class="w-full px-4 py-3 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg cursor-not-allowed">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Este es el correo al que se envió la invitación
                                    </p>
                                </div>

                                <!-- Name -->
                                <div>
                                    <label for="name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Nombre completo <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        required autofocus
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                        placeholder="Tu nombre completo">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Número de teléfono <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                        required
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                                        placeholder="Ejemplo: +51981234567">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div>
                                    <label for="password"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Contraseña <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" name="password" id="password" required
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                        placeholder="Mínimo 8 caracteres">
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Password Confirmation -->
                                <div>
                                    <label for="password_confirmation"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Confirmar contraseña <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        required
                                        class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                        placeholder="Repite tu contraseña">
                                </div>

                                <!-- Role Info -->
                                <div
                                    class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 rounded-lg p-4">
                                    <div class="flex">
                                        <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400 mt-0.5 mr-3"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-indigo-900 dark:text-indigo-200">
                                                Tu rol en este plan
                                            </h4>
                                            <p class="mt-1 text-sm text-indigo-700 dark:text-indigo-300">
                                                Serás agregado como
                                                <strong>{{ $invitation->role === 'guest' ? 'Invitado' : 'Editor' }}</strong>
                                                @if ($invitation->role === 'editor')
                                                    - Podrás editar el plan
                                                @else
                                                    - Podrás ver los detalles del plan
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                    class="w-full flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors shadow-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Crear cuenta y unirme al plan
                                </button>

                                <!-- Terms -->
                                <p class="text-xs text-center text-gray-500 dark:text-gray-400">
                                    Al crear tu cuenta, aceptas nuestros
                                    <a href="#"
                                        class="text-indigo-600 dark:text-indigo-400 hover:underline">Términos de
                                        Servicio</a>
                                    y
                                    <a href="#"
                                        class="text-indigo-600 dark:text-indigo-400 hover:underline">Política de
                                        Privacidad</a>
                                </p>
                            </form>
                        </div>

                        <!-- Already have account -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                ¿Ya tienes una cuenta?
                                <a href="{{ route('login') }}"
                                    class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 hover:underline">
                                    Inicia sesión aquí
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
