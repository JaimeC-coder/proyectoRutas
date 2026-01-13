<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Información del Plan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg ">
                <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                        <!-- Header con botón de volver -->
                        <div class="mb-6">
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Volver a mis planes
                            </a>
                        </div>

                        <!-- Success/Info Messages -->
                        @if (session('success'))
                            <div
                                class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-green-600 dark:text-green-400 mr-3" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-sm text-green-800 dark:text-green-300">{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif

                        @if (session('info'))
                            <div
                                class="mb-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-blue-600 dark:text-blue-400 mr-3" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-sm text-blue-800 dark:text-blue-300">{{ session('info') }}</p>
                                </div>
                            </div>
                        @endif

                        {{$plan->users }}

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                            <!-- Main Content - Plan Details -->
                            <div class="lg:col-span-2 space-y-6">

                                <!-- Plan Header Card -->
                                <div
                                    class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                    <!-- Banner con gradiente -->
                                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-8 text-white">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h1 class="text-3xl font-bold mb-2">{{ $plan->name }}</h1>

                                                @if ($plan->difficulty)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 backdrop-blur-sm">
                                                        @if ($plan->difficulty === 'easy')
                                                            🟢 Fácil
                                                        @elseif($plan->difficulty === 'medium')
                                                            🟡 Media
                                                        @else
                                                            🔴 Difícil
                                                        @endif
                                                    </span>
                                                @endif
                                            </div>

                                            @if ($plan->user_id === Auth::id())
                                                <div class="flex gap-2">
                                                    <a href="{{ route('plans.edit', $plan->id) }}"
                                                        class="inline-flex items-center px-3 py-2 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white rounded-lg transition-colors">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                            </path>
                                                        </svg>
                                                        Editar
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Plan Details -->
                                    <div class="px-6 py-6">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="flex items-center justify-center h-12 w-12 rounded-lg bg-indigo-100 dark:bg-indigo-900/20">
                                                        <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Fecha</p>
                                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                                        {{ \Carbon\Carbon::parse($plan->date)->format('d/m/Y') }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ \Carbon\Carbon::parse($plan->date)->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="flex items-center justify-center h-12 w-12 rounded-lg bg-purple-100 dark:bg-purple-900/20">
                                                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Hora de
                                                        encuentro</p>
                                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                                        {{ $plan->time_out }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-start md:col-span-2">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="flex items-center justify-center h-12 w-12 rounded-lg bg-green-100 dark:bg-green-900/20">
                                                        <svg class="h-6 w-6 text-green-600 dark:text-green-400"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Lugar de
                                                        encuentro</p>
                                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                                        {{ $plan->meeting_place }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($plan->description)
                                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                                                    Descripción</h3>
                                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                                    {{ $plan->description }}
                                                </p>
                                            </div>
                                        @endif

                                        @if ($plan->observations)
                                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                                                    Observaciones</h3>
                                                <div
                                                    class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                                                    <p class="text-gray-700 dark:text-gray-300">
                                                        {{ $plan->observations }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="space-y-6">

                                <!-- Organizador Card -->
                                <div
                                    class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                    <div
                                        class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Organizador
                                        </h3>
                                    </div>
                                    <div class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-lg">
                                                {{ substr($plan->creator->name, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $plan->creator->name }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $plan->creator->email }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Participants Card -->
                                <div
                                    class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                    <div
                                        class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            Participantes ({{ $plan->users->count() + 1 }})
                                        </h3>
                                    </div>
                                    <div class="px-6 py-4">
                                        <ul class="space-y-3">
                                            <!-- Organizador siempre primero -->
                                            <li class="flex items-center justify-between">
                                                <div class="flex items-center min-w-0 flex-1">
                                                    <div
                                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-medium">
                                                        {{ substr($plan->creator->name, 0, 1) }}
                                                    </div>
                                                    <div class="ml-3 min-w-0 flex-1">
                                                        <p
                                                            class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                            {{ $plan->creator->name }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                                            Organizador
                                                        </p>
                                                    </div>
                                                </div>
                                                <span
                                                    class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/20 dark:text-indigo-300">
                                                    👑
                                                </span>
                                            </li>

                                            @forelse($plan->users as $user)
                                                <li class="flex items-center justify-between">
                                                    <div class="flex items-center min-w-0 flex-1">
                                                        <div
                                                            class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-400 dark:bg-gray-600 flex items-center justify-center text-white font-medium">
                                                            {{ substr($user->name, 0, 1) }}
                                                        </div>
                                                        <div class="ml-3 min-w-0 flex-1">
                                                            <p
                                                                class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                                {{ $user->name }}
                                                            </p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                                {{ $user->pivot->role === 'editor' ? 'Editor' : 'Invitado' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    @if ($user->pivot->role === 'editor')
                                                        <span
                                                            class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300">
                                                            ✏️
                                                        </span>
                                                    @endif
                                                </li>
                                            @empty
                                                <li class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">
                                                    No hay otros participantes aún
                                                </li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>

                                <!-- Quick Actions -->
                                @if ($plan->user_id === Auth::id())
                                    <div
                                        class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                        <div
                                            class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Acciones
                                            </h3>
                                        </div>
                                        <div class="px-6 py-4 space-y-2">
                                            <a href="{{ route('plans.edit', $plan->id) }}"
                                                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                Editar plan
                                            </a>

                                            <form action="{{ route('plans.destroy', $plan->id) }}" method="POST"
                                                onsubmit="return confirm('¿Estás seguro de eliminar este plan?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-full flex items-center justify-center px-4 py-2 border border-red-300 dark:border-red-600 rounded-lg text-sm font-medium text-red-700 dark:text-red-400 bg-white dark:bg-gray-700 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                    Eliminar plan
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
