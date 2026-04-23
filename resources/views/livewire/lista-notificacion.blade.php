<div class="p-6 max-w-2xl mx-auto space-y-5"
    x-data
    x-init="
        setTimeout(() => {
            window.Echo.channel('notificaciones.{{ auth()->id() }}')
                .listen('.nueva.notificacion', (e) => {
                    console.log('llegó', e);
                    $wire.$refresh();
                })
        }, 1000)
    ">

    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Notificaciones</h1>
        <div class="flex items-center gap-3">
            <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300 cursor-pointer">
                <input wire:model.live="soloNoLeidas" type="checkbox" class="rounded text-purple-600" />
                Solo no leídas
            </label>
            <button wire:click="marcarTodasLeidas"
                class="text-sm text-purple-600 hover:underline">
                Marcar todas leídas
            </button>
        </div>
    </div>

    <div class="space-y-2">
        @forelse($notificaciones as $notif)
        <div class="rounded-xl px-4 py-3 border flex items-start gap-3
            {{ !$notif->leida
                ? 'border-purple-200 dark:border-purple-700 bg-purple-50 dark:bg-purple-950'
                : 'bg-white dark:bg-gray-800 border-gray-100 dark:border-gray-700' }}">

            <span class="mt-0.5 w-2 h-2 rounded-full shrink-0
                {{ !$notif->leida ? 'bg-purple-500' : 'bg-gray-300' }}">
            </span>

            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $notif->titulo }}</p>
                @if($notif->contenido)
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $notif->contenido }}</p>
                @endif
                <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
            </div>

            @if(!$notif->leida)
                <button wire:click="marcarLeida({{ $notif->id }})"
                    class="text-xs text-purple-600 hover:underline shrink-0">
                    Leída
                </button>
            @endif
        </div>
        @empty
            <div class="text-center py-12 text-gray-400">
                <p>Sin notificaciones pendientes</p>
            </div>
        @endforelse
    </div>

    {{ $notificaciones->links() }}
</div>