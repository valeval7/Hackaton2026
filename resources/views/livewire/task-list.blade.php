<div class="p-6 space-y-5">
  <div class="flex items-center justify-between">
    <h1 class="text-2xl font-semibold text-lavender">Mis Tareas</h1>
    <a href="{{ route('tasks.index') }}"
      class="px-4 py-2 bg-yinmn hover:bg-yinmn/80 text-lavender text-sm
                  rounded-lg border border-jordy/20 transition">
      + Nueva tarea
    </a>
  </div>

  {{-- Filtros --}}
  <div class="flex flex-wrap gap-3">
    <input wire:model.live.debounce.300ms="busqueda" type="text"
      placeholder="Buscar tarea..."
      class="bg-cadet border border-yinmn/40 text-lavender placeholder-jordy/40
                      rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-jordy transition" />

    <select wire:model.live="filtroEstado"
      class="bg-cadet border border-yinmn/40 text-lavender rounded-lg px-3 py-2 text-sm
                      focus:outline-none focus:border-jordy transition">
      <option value="">Todos los estados</option>
      <option value="pendiente">Pendiente</option>
      <option value="en_progreso">En progreso</option>
      <option value="completada">Completada</option>
    </select>

    <select wire:model.live="filtroPrioridad"
      class="bg-cadet border border-yinmn/40 text-lavender rounded-lg px-3 py-2 text-sm
                      focus:outline-none focus:border-jordy transition">
      <option value="">Toda prioridad</option>
      <option value="alta">Alta</option>
      <option value="media">Media</option>
      <option value="baja">Baja</option>
    </select>

    <select wire:model.live="filtroMateria"
      class="bg-cadet border border-yinmn/40 text-lavender rounded-lg px-3 py-2 text-sm
                      focus:outline-none focus:border-jordy transition">
      <option value="">Todas las materias</option>
      @foreach($materias as $materia)
      <option value="{{ $materia }}">{{ $materia }}</option>
      @endforeach
    </select>
  </div>

  {{-- Lista --}}
  <div class="space-y-2">
    @forelse($tareas as $tarea)
    <div class="bg-cadet rounded-xl px-4 py-3 border flex items-center gap-4
                        hover:border-jordy/40 transition
                        {{ $tarea->isVencida() ? 'border-red-500/40' : 'border-yinmn/30' }}">

      <input type="checkbox"
        wire:click="cambiarEstado({{ $tarea->id }}, '{{ $tarea->status === 'completada' ? 'pendiente' : 'completada' }}')"
        @checked($tarea->status === 'completada')
      class="w-4 h-4 rounded accent-jordy cursor-pointer" />

      <div class="flex-1 min-w-0">
        <p class="text-sm text-lavender truncate
                              {{ $tarea->status === 'completada' ? 'line-through opacity-40' : '' }}">
          {{ $tarea->title }}
        </p>
        <p class="text-xs text-jordy/60 mt-0.5">
          {{ $tarea->subject ?? 'Sin materia' }}
          @if($tarea->due_date)
          · {{ $tarea->due_date->format('d M Y') }}
          @if($tarea->isVencida())
          <span class="text-red-400">· Vencida</span>
          @endif
          @endif
        </p>
      </div>

      <span class="text-xs px-2 py-1 rounded-full shrink-0
                    {{ $tarea->priority === 'alta'  ? 'bg-red-500/20 text-red-300'   :
                      ($tarea->priority === 'media' ? 'bg-yinmn/60 text-jordy'       :
                                                      'bg-yinmn/20 text-jordy/70') }}">
        {{ ucfirst($tarea->priority) }}
      </span>

      <button wire:click="eliminar({{ $tarea->id }})"
        wire:confirm="¿Eliminar esta tarea?"
        class="text-jordy/30 hover:text-red-400 transition text-xs shrink-0">✕</button>
    </div>
    @empty
    <div class="text-center py-16 text-jordy/40">
      <p>No hay tareas aún — agrega la primera</p>
    </div>
    @endforelse
  </div>
  <div class="text-jordy/50">{{ $tareas->links() }}</div>
</div>