<div class="grid grid-cols-1 md:grid-cols-1 gap-3 lg:gap-1">
    <div
        class="w-full relative overflow-x-auto  shadow-xs rounded-base border border-default dark:border-neutral-secondary bg-green-400 ">

        <h1 class="text-center text-2xl  "> Lista de PLanes confirmados</h1>

        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead
                class="text-sm text-body  rounded-base border-default dark:text-white dark:divide-neutral-secondary border-b">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nombre del Plan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha y Hora
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Lugar de Encuentro
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Dificultad
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-default dark:text-white dark:divide-neutral-secondary border-b ">

                @forelse ($plansAccepted as $plan)
                <tr class="bg-neutral-primary border-b border-default hover:bg-neutral-secondary transition-colors">
                    <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                        {{ $plan->name }}
                    </th>
                    <td class="px-6 py-4 text-body">
                        {{ \Carbon\Carbon::parse($plan->date)->format('d/m/Y') }} -
                        {{ \Carbon\Carbon::parse($plan->time_out)->format('H:i') }}
                    </td>
                    <td class="px-6 py-4 text-body">
                        {{ $plan->meeting_place }}
                    </td>
                    <td class="px-6 py-4">
                        @switch($plan->difficulty)
                        @case('easy')
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            Fácil
                        </span>
                        @break

                        @case('medium')
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            Media
                        </span>
                        @break

                        @case('hard')
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            Difícil
                        </span>
                        @break

                        @default
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                            N/A
                        </span>
                        @endswitch
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            {{-- <a href="{{ route('plans.show', $plan->id) }}"
                                class="text-brand hover:text-brand-dark font-medium text-sm transition-colors">
                                Ver
                            </a>
                            <a href="{{ route('plans.edit', $plan->id) }}"
                                class="text-blue-600 hover:text-blue-800 font-medium text-sm transition-colors">
                                Editar
                            </a>
                            <button wire:click="deletePlan({{ $plan->id }})"
                                wire:confirm="¿Estás seguro de eliminar este plan?"
                                class="text-red-600 hover:text-red-800 font-medium text-sm transition-colors">
                                Eliminar
                            </button> --}}
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-body">
                        <div class="flex flex-col items-center gap-2">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            <p class="text-lg font-medium text-heading">No hay planes disponibles</p>
                            <p class="text-sm text-body">Crea tu primer plan para comenzar</p>
                            <a href="{{ route('plans.create') }}"
                                class="mt-4 inline-flex items-center px-4 py-2 bg-brand text-white rounded-base hover:bg-brand-dark transition-colors">
                                Crear plan
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse




            </tbody>
        </table>
    </div>
    <div
        class="w-full relative overflow-x-auto bg-blue-400 bg-neutral-primary-soft shadow-xs rounded-base border border-default dark:border-neutral-secondary">

        <h1 class="text-center text-2xl"> Lista de Planes por confirmados</h1>

        <table class="w-full text-sm text-left rtl:text-right text-body bg-blue-400">
            <thead
                class="text-sm text-body bg-neutral-secondary-soft rounded-base border-default dark:text-white dark:divide-neutral-secondary border-b">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nombre del Plan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha y Hora
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Lugar de Encuentro
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Dificultad
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-default dark:text-white dark:divide-neutral-secondary border-b ">

                @forelse ($plansPendientes as $plan)
                <tr class="bg-neutral-primary border-b border-default hover:bg-neutral-secondary transition-colors">
                    <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                        {{ $plan->name }}
                    </th>
                    <td class="px-6 py-4 text-body">
                        {{ \Carbon\Carbon::parse($plan->date)->format('d/m/Y') }} -
                        {{ \Carbon\Carbon::parse($plan->time_out)->format('H:i') }}
                    </td>
                    <td class="px-6 py-4 text-body">
                        {{ $plan->meeting_place }}
                    </td>
                    <td class="px-6 py-4">
                        @switch($plan->difficulty)
                        @case('easy')
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            Fácil
                        </span>
                        @break

                        @case('medium')
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            Media
                        </span>
                        @break

                        @case('hard')
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            Difícil
                        </span>
                        @break

                        @default
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                            N/A
                        </span>
                        @endswitch
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            {{-- <a href="{{ route('plans.show', $plan->id) }}"
                                class="text-brand hover:text-brand-dark font-medium text-sm transition-colors">
                                Ver
                            </a>
                            <a href="{{ route('plans.edit', $plan->id) }}"
                                class="text-blue-600 hover:text-blue-800 font-medium text-sm transition-colors">
                                Editar
                            </a>
                            <button wire:click="deletePlan({{ $plan->id }})"
                                wire:confirm="¿Estás seguro de eliminar este plan?"
                                class="text-red-600 hover:text-red-800 font-medium text-sm transition-colors">
                                Eliminar
                            </button> --}}
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-body">
                        <div class="flex flex-col items-center gap-2">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            <p class="text-lg font-medium text-heading">No hay planes disponibles</p>
                            <p class="text-sm text-body">Crea tu primer plan para comenzar</p>
                            <a href="{{ route('plans.create') }}"
                                class="mt-4 inline-flex items-center px-4 py-2 bg-brand text-white rounded-base hover:bg-brand-dark transition-colors">
                                Crear plan
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse




            </tbody>
        </table>
    </div>
    <div
        class="w-full relative overflow-x-auto bg-red-500 shadow-xs rounded-base border border-default dark:border-neutral-secondary">

        <h1 class="text-center text-2xl"> Lista de Planes por Rechazados</h1>

        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead
                class="text-sm text-body bg-neutral-secondary-soft rounded-base border-default dark:text-white dark:divide-neutral-secondary border-b">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nombre del Plan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha y Hora
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Lugar de Encuentro
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Dificultad
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-default dark:text-white dark:divide-neutral-secondary border-b ">

                @forelse ($planesRefused as $plan)
                <tr class="bg-neutral-primary border-b border-default hover:bg-neutral-secondary transition-colors">
                    <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                        {{ $plan->name }}
                    </th>
                    <td class="px-6 py-4 text-body">
                        {{ \Carbon\Carbon::parse($plan->date)->format('d/m/Y') }} -
                        {{ \Carbon\Carbon::parse($plan->time_out)->format('H:i') }}
                    </td>
                    <td class="px-6 py-4 text-body">
                        {{ $plan->meeting_place }}
                    </td>
                    <td class="px-6 py-4">
                        @switch($plan->difficulty)
                        @case('easy')
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            Fácil
                        </span>
                        @break

                        @case('medium')
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            Media
                        </span>
                        @break

                        @case('hard')
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            Difícil
                        </span>
                        @break

                        @default
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                            N/A
                        </span>
                        @endswitch
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-body">
                        <div class="flex flex-col items-center gap-2">

                            <p class="text-lg font-medium text-heading">No tienes planes rechazados</p>

                        </div>
                    </td>
                </tr>
                @endforelse




            </tbody>
        </table>
    </div>

</div>
