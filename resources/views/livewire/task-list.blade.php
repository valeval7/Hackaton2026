{{-- resources/views/livewire/task-list.blade.php --}}
<div class="p-6 space-y-5">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Mis Tareas</h1>
        <a href="{{ route('tasks.create') }}"
           class="px-4 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition">
            + Nueva tarea
        </a>
    </div>

    {{-- Filtros --}}
    <div class="flex flex-wrap gap-3">
        <input wire:model.live.debounce.300ms="busqueda" type="text"
               placeholder="Buscar tarea..."
               class="border rounded-lg px-3 py-2 text-sm dark:bg-gray-800 dark:border-gray-600 dark:text-white" />

        <select wire:model.live="filtroEstado"
                class="border rounded-lg px-3 py-2 text-sm dark:bg-gray-800 dark:border-gray-600 dark:text-white">
            <option value="">Todos los estados</option>
            <option value="pendiente">Pendiente</option>
            <option value="en_progreso">En progreso</option>
            <option value="completada">Completada</option>
        </select>

        <select wire:model.live="filtroPrioridad"
                class="border rounded-lg px-3 py-2 text-sm dark:bg-gray-800 dark:border-gray-600 dark:text-white">
            <option value="">Toda prioridad</option>
            <option value="alta">Alta</option>
            <option value="media">Media</option>
            <option value="baja">Baja</option>
        </select>

        <select wire:model.live="filtroMateria"
                class="border rounded-lg px-3 py-2 text-sm dark:bg-gray-800 dark:border-gray-600 dark:text-white">
            <option value="">Todas las materias</option>
            @foreach($materias as $materia)
                <option value="{{ $materia }}">{{ $materia }}</option>
            @endforeach
        </select>
    </div>

    {{-- Lista --}}
    <div class="space-y-3">
        @forelse($tareas as $tarea)
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border
                {{ $tarea->isVencida() ? 'border-red-300 dark:border-red-700' : 'border-gray-100 dark:border-gray-700' }}
                flex items-center gap-4">

                {{-- Checkbox de completar --}}
                <input type="checkbox"
                       wire:click="cambiarEstado({{ $tarea->id }}, '{{ $tarea->status === 'completada' ? 'pendiente' : 'completada' }}')"
                       @checked($tarea->status === 'completada')
                       class="w-5 h-5 rounded text-purple-600 cursor-pointer" />

                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-800 dark:text-white truncate
                        {{ $tarea->status === 'completada' ? 'line-through text-gray-400' : '' }}">
                        {{ $tarea->title }}
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $tarea->subject ?? 'Sin materia' }}
                        @if($tarea->due_date)
                            · {{ $tarea->due_date->format('d M Y') }}
                            @if($tarea->isVencida())
                                <span class="text-red-500 font-medium">· Vencida</span>
                            @endif
                        @endif
                    </p>
                </div>

                {{-- Badge prioridad --}}
                <span class="text-xs px-2 py-1 rounded-full shrink-0
                    {{ $tarea->priority === 'alta'  ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' :
                       ($tarea->priority === 'media' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300' :
                                                       'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300') }}">
                    {{ ucfirst($tarea->priority) }}
                </span>

                <button wire:click="eliminar({{ $tarea->id }})"
                        wire:confirm="¿Eliminar esta tarea?"
                        class="text-gray-300 hover:text-red-500 transition ml-1 shrink-0">
                    ✕
                </button>
            </div>
        @empty
            <div class="text-center py-12 text-gray-400">
                <p class="text-lg">No hay tareas aún</p>
                <p class="text-sm mt-1">¡Agrega tu primera tarea!</p>
            </div>
        @endforelse
    </div>

    {{ $tareas->links() }}
</div>