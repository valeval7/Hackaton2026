<div class="p-6 max-w-2xl mx-auto">
  <h1 class="text-2xl font-semibold text-lavender mb-6">Nueva Tarea</h1>

  @if(session('mensaje'))
  <div class="mb-4 px-4 py-3 bg-yinmn/30 border border-jordy/30 rounded-lg text-jordy text-sm">
    {{ session('mensaje') }}
  </div>
  @endif

  <form wire:submit="guardar"
    class="bg-cadet rounded-xl p-6 border border-yinmn/40 space-y-5">

    <div>
      <label class="block text-xs font-medium text-jordy uppercase tracking-wider mb-1.5">Título *</label>
      <input wire:model.live="title" type="text"
        placeholder="Ej: Tarea de Cálculo capítulo 5"
        class="w-full bg-oxford border border-yinmn/40 text-lavender placeholder-jordy/40
                          rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-jordy transition
                          @error('title') border-red-500/60 @enderror" />
      @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-xs font-medium text-jordy uppercase tracking-wider mb-1.5">Materia</label>
        <input wire:model="subject" type="text" placeholder="Matemáticas, Física..."
          class="w-full bg-oxford border border-yinmn/40 text-lavender placeholder-jordy/40
                              rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-jordy transition" />
      </div>
      <div>
        <label class="block text-xs font-medium text-jordy uppercase tracking-wider mb-1.5">Prioridad</label>
        <select wire:model="priority"
          class="w-full bg-oxford border border-yinmn/40 text-lavender rounded-lg
                               px-3 py-2.5 text-sm focus:outline-none focus:border-jordy transition">
          <option value="baja">Baja</option>
          <option value="media">Media</option>
          <option value="alta">Alta</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-xs font-medium text-jordy uppercase tracking-wider mb-1.5">Fecha límite</label>
        <input wire:model.live="due_date" type="date"
          class="w-full bg-oxford border border-yinmn/40 text-lavender rounded-lg
                              px-3 py-2.5 text-sm focus:outline-none focus:border-jordy transition
                              @error('due_date') border-red-500/60 @enderror" />
        @error('due_date') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
      </div>
      <div>
        <label class="block text-xs font-medium text-jordy uppercase tracking-wider mb-1.5">Tiempo estimado (min)</label>
        <input wire:model="estimated_minutes" type="number" min="5" max="480" placeholder="60"
          class="w-full bg-oxford border border-yinmn/40 text-lavender placeholder-jordy/40
                              rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-jordy transition" />
        @error('estimated_minutes') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
      </div>
    </div>

    <div>
      <label class="block text-xs font-medium text-jordy uppercase tracking-wider mb-1.5">Descripción</label>
      <textarea wire:model="description" rows="3" placeholder="Detalles adicionales..."
        class="w-full bg-oxford border border-yinmn/40 text-lavender placeholder-jordy/40
                             rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-jordy
                             transition resize-none"></textarea>
    </div>

    <div class="flex justify-end gap-3 pt-2">
      <a href="{{ route('tasks.index') }}"
        class="px-4 py-2 text-sm text-jordy border border-yinmn/40 rounded-lg hover:bg-yinmn/20 transition">
        Cancelar
      </a>
      <button type="submit"
        class="px-5 py-2 bg-yinmn hover:bg-yinmn/80 text-lavender text-sm
                           rounded-lg border border-jordy/20 transition">
        <span wire:loading.remove>Guardar tarea</span>
        <span wire:loading>Guardando...</span>
      </button>
    </div>
  </form>
</div>