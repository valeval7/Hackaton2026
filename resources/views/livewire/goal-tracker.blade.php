<div class="p-6 space-y-6">
  <div class="flex items-center justify-between">
    <h1 class="text-2xl font-semibold text-lavender">Mis Metas</h1>
    <button wire:click="$toggle('mostrarFormulario')"
      class="px-4 py-2 bg-yinmn hover:bg-yinmn/80 text-lavender text-sm
                      rounded-lg border border-jordy/20 transition">
      {{ $mostrarFormulario ? 'Cancelar' : '+ Nueva meta' }}
    </button>
  </div>

  @if($mostrarFormulario)
  <form wire:submit="guardarMeta"
    class="bg-cadet border border-jordy/30 rounded-xl p-5 space-y-4">
    <div class="grid grid-cols-2 gap-4">
      <div class="col-span-2">
        <label class="block text-xs text-jordy uppercase tracking-wider mb-1.5">Título *</label>
        <input wire:model="title" type="text" placeholder="Ej: Aprobar Cálculo"
          class="w-full bg-oxford border border-yinmn/40 text-lavender placeholder-jordy/40
                                  rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-jordy transition
                                  @error('title') border-red-500/60 @enderror" />
        @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-xs text-jordy uppercase tracking-wider mb-1.5">Categoría</label>
        <select wire:model="category"
          class="w-full bg-oxford border border-yinmn/40 text-lavender rounded-lg
                                  px-3 py-2.5 text-sm focus:outline-none focus:border-jordy transition">
          <option value="academica">Académica</option>
          <option value="personal">Personal</option>
          <option value="habito">Hábito</option>
        </select>
      </div>
      <div>
        <label class="block text-xs text-jordy uppercase tracking-wider mb-1.5">Fecha límite</label>
        <input wire:model="target_date" type="date"
          class="w-full bg-oxford border border-yinmn/40 text-lavender rounded-lg
                                  px-3 py-2.5 text-sm focus:outline-none focus:border-jordy transition
                                  @error('target_date') border-red-500/60 @enderror" />
        @error('target_date')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
      </div>
    </div>
    <button type="submit"
      class="px-5 py-2 bg-yinmn hover:bg-yinmn/80 text-lavender text-sm
                          rounded-lg border border-jordy/20 transition">
      Crear meta
    </button>
  </form>
  @endif

  <div class="space-y-4">
    @forelse($metas as $meta)
    <div class="bg-cadet border border-yinmn/30 hover:border-jordy/40 rounded-xl p-5 transition">
      <div class="flex items-start justify-between mb-3">
        <div>
          <p class="font-medium text-lavender {{ $meta->completed ? 'line-through opacity-40' : '' }}">
            {{ $meta->title }}
          </p>
          <p class="text-xs text-jordy/60 mt-0.5">
            {{ ucfirst($meta->category) }} · {{ $meta->target_date->format('d M Y') }}
          </p>
        </div>
        <button wire:click="eliminarMeta({{ $meta->id }})"
          wire:confirm="¿Eliminar esta meta?"
          class="text-jordy/30 hover:text-red-400 transition text-xs">✕</button>
      </div>
      <div class="flex items-center gap-3 mb-2">
        <div class="flex-1 bg-oxford rounded-full h-1.5">
          <div x-data
            :style="'width: {{ $meta->progress }}%'">
          </div>
          <span class="text-xs font-mono text-jordy w-10 text-right">{{ $meta->progress }}%</span>
        </div>
        @unless($meta->completed)
        <input type="range" min="0" max="100" value="{{ $meta->progress }}"
          wire:change="actualizarProgreso({{ $meta->id }}, $event.target.value)"
          class="w-full cursor-pointer accent-jordy" />
        @endunless
      </div>
      @empty
      <div class="text-center py-16 text-jordy/40">
        <p>Sin metas — define tus objetivos para mantenerte enfocado</p>
      </div>
      @endforelse
    </div>
  </div>