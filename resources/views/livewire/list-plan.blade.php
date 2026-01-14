<div class="grid grid-cols-1 md:grid-cols-1 gap-3 lg:gap-1">




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
                    Estado
                </th>
                <th scope="col" class="px-6 py-3">
                    sincronizado con calendario??
                </th>
                <th scope="col" class="px-6 py-3">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody
            class="divide-y divide-default dark:text-white dark:divide-neutral-secondary border-b
                        ">

            @forelse ($allPlanes as $plan)
                {{$plan}}
                <tr
                    class="bg-neutral-primary border-b border-default hover:bg-neutral-secondary transition-colors
                        @switch($plan->status)
                            @case('accepted')
                                hola
                                bg-green-400
                                @break
                            @case('pending')
                            hola1
                                bg-blue-400
                                @break
                            @case('refused')
                            hola2
                                bg-red-500
                            @break
                            @default

                                bg-white

                @endswitch
                    ">
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
                    @switch($plan->status)
                        @case('pending')
                            <td class="px-6 py-4 text-body">
                                {{ ucfirst('Pendiente') }}
                            </td>
                            <td class="px-6 py-4 text-body">
                                No
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <button wire:click="acceptPlan({{ $plan->id }})"
                                        class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-base hover:bg-green-600 transition-colors">
                                        Aceptar
                                    </button>
                                    <button wire:click="refusePlan({{ $plan->id }})"
                                        class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-base hover:bg-red-600 transition-colors">
                                        Rechazar
                                    </button>
                                </div>
                            </td>
                        @break

                        @case('accepted')
                            <td class="px-6 py-4 text-body">
                                {{ ucfirst('Acceptado') }}
                            </td>
                            <td class="px-6 py-4 text-body">
                                {{ $plan->synced_at ? 'Sí' : 'No' }}
                            </td>


                            @if ($plan->user_id === Auth::id())
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <button wire:click="deletePlan({{ $plan->id }})"
                                            class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-base hover:bg-red-600 transition-colors">
                                            Eliminar
                                        </button>
                                        @if (!$plan->synced_at)

                                        <button wire:click="syncPlan({{ $plan->id }})"
                                            class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-base hover:bg-blue-600 transition-colors">
                                            Sincronizar
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            @else
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <button wire:click="refusePlan({{ $plan->id }})"
                                            class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-base hover:bg-red-600 transition-colors">
                                            Rechazar
                                        </button>
                                         @if (!$plan->synced_at)
                                            hola
                                            <button wire:click="syncPlan({{ $plan->id }})"
                                                class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-base hover:bg-blue-600 transition-colors">
                                                Sincronizar
                                            </button>
                                        @else
                                            hola2
                                        @endif
                                    </div>
                                </td>
                            @endif
                        @break

                        @case('refused')
                            <td class="px-6 py-4 text-body">
                                {{ ucfirst('Rechazado') }}
                            </td>
                            <td class="px-6 py-4 text-body">
                                No
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <button wire:click="acceptPlan({{ $plan->id }})"
                                        class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-base hover:bg-green-600 transition-colors">
                                        Aceptar
                                    </button>
                                </div>
                            </td>
                        @break

                        @default
                            <td class="px-6 py-4 text-body">
                                {{ ucfirst('N/A') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">

                                </div>
                            </td>
                    @endswitch
                    <td class="px-6 py-4 text-body">

                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">


                        </div>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-body">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
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
