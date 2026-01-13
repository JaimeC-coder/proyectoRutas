<div class="grid grid-cols-1 md:grid-cols-1 gap-3 lg:gap-1">
    <div class="w-full p-6 border border-default rounded-base shadow-xs dark:bg-gray-800 dark:border-gray-700">

        @error('selectedUsers.*')
            <div title="Error en la lista de productos!" negative>

                <ul class="mt-2 list-disc list-outside space-y-1 ps-2.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>


            </div>
        @enderror



        <form wire:submit.prevent='saveplan' class="space-y-4">

            <div class="mb-5">
                <label for="plan-name" class="block mb-3 text-sm font-medium text-heading dark:text-gray-300">
                    Nombre del plan <span class="text-red-500">*</span>
                </label>
                <input type="text" id="plan-name"
                    class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                    wire:model="name" placeholder="Ej: Caminata al Cerro Campana">
                @error('name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>



            <div class="grid gap-6 mb-6 md:grid-cols-3">
                <div class="mb-5">
                    <label for="plan-start-date" class="block mb-3 text-sm font-medium text-heading dark:text-gray-300">
                        Fecha del plan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="plan-start-date"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs"
                        wire:model="start_date">
                    @error('start_date')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="plan-time" class="block mb-3 text-sm font-medium text-heading dark:text-gray-300">
                        Hora de encuentro <span class="text-red-500">*</span>
                    </label>
                    <input type="time" id="plan-time"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs"
                        wire:model="time_out">
                    @error('time_out')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="plan-end-date" class="block mb-3 text-sm font-medium text-heading dark:text-gray-300">
                       Fecha de fin (opcional)
                    </label>
                    <input type="date" id="plan-end-date"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs"
                        wire:model="end_date">
                    @error('end_date')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>


            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div class="mb-5">
                    <label for="plan-meeting" class="block mb-3 text-sm font-medium text-heading dark:text-gray-300">
                        Lugar de encuentro <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="plan-meeting"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                        wire:model="meeting_place" placeholder="Ej: Plaza de Armas">
                    @error('meeting_place')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="plan-difficulty" class="block mb-3 text-sm font-medium text-heading dark:text-gray-300">
                        Dificultad del plan
                    </label>
                    <select id="plan-difficulty" wire:model="difficulty"
                        class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs">
                        <option value="">Seleccione una dificultad</option>
                        <option value="easy">Fácil</option>
                        <option value="medium">Media</option>
                        <option value="hard">Difícil</option>
                    </select>
                    @error('difficulty')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div class="mb-5">
                    <label for="plan-description"
                        class="block mb-3 text-sm font-medium text-heading dark:text-gray-300">
                        Descripción del plan (opcional)
                    </label>
                    <textarea id="plan-description" rows="4" wire:model="description"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full p-3.5 shadow-xs placeholder:text-body"
                        placeholder="Describe los detalles del plan..."></textarea>
                    @error('description')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="plan-observations"
                        class="block mb-3 text-sm font-medium text-heading dark:text-gray-300">
                        Observaciones del plan (opcional)
                    </label>
                    <textarea id="plan-observations" rows="4" wire:model="observations"
                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full p-3.5 shadow-xs placeholder:text-body"
                        placeholder="Añade cualquier información adicional..."></textarea>
                    @error('observations')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div class="mb-5">
                    <fieldset>
                        <legend class="block mb-3 text-sm font-medium text-heading dark:text-gray-300">Invitar usuarios
                        </legend>

                        @forelse ($users as $user)
                            <div class="flex mb-4 items-start">
                                <div class="flex items-center h-5 mt-1">
                                    <input id="user-{{ $user->id }}" type="checkbox"
                                        wire:model="selectedUsers.{{ $user->id }}.selected"
                                        class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft dark:bg-gray-700 dark:border-gray-600">
                                </div>
                                <div class="ms-3 text-sm flex-1">
                                    <label for="user-{{ $user->id }}"
                                        class="font-medium text-heading dark:text-gray-300 cursor-pointer">
                                        {{ $user->name }}
                                    </label>
                                    <p class="text-xs text-body mb-2 dark:text-gray-300 cursor-pointer">
                                        {{ $user->email }}</p>

                                    @if (isset($selectedUsers[$user->id]['selected']) && $selectedUsers[$user->id]['selected'])
                                        <select wire:model="selectedUsers.{{ $user->id }}.role"
                                            class="block w-full px-3 py-2 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs">
                                            <option value="">Seleccione una opcion</option>
                                            <option value="guest">Invitado</option>
                                            <option value="editor">Editor</option>
                                        </select>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-2xl text-body dark:text-white">No hay usuarios disponibles para invitar. :C</p>
                        @endforelse
                    </fieldset>
                </div>
                <div class="mb-5">
                    <fieldset class="mb-5">
                        <legend class="block mb-3 text-sm font-medium text-heading dark:text-gray-300">
                            Invitar por correo electrónico
                        </legend>

                        @foreach ($inviteEmails as $index => $email)
                            <div class="flex gap-2 mb-3">
                                <input type="email" wire:model="inviteEmails.{{ $index }}"
                                    class="flex-1 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand px-3 py-2.5 shadow-xs placeholder:text-body"
                                    placeholder="ejemplo@correo.com">

                                @if ($index > 0)
                                    <button type="button" wire:click="removeEmailField({{ $index }})"
                                        class="px-3 py-2 bg-red-500 text-white rounded-base hover:bg-red-600">
                                        Eliminar
                                    </button>
                                @endif
                            </div>
                            @error("inviteEmails.{$index}")
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        @endforeach

                        <button type="button" wire:click="addEmailField"
                            class="mt-2 px-4 py-2 bg-brand text-white rounded-base hover:bg-brand-dark text-sm">
                            + Agregar otro correo
                        </button>
                    </fieldset>
                </div>

            </div>




























            <div class="flex gap-3 pt-4">
                <x-button href="{{ route('plans.index') }}" type="button">
                    Cancelar
                </x-button>
                <x-button type="submit" variant="secondary">
                    Crear plan
                </x-button>
            </div>
        </form>
    </div>
</div>
