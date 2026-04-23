<div class="p-6 bg-[#d9e1f1] min-h-screen">
    <div>
        {{-- MÉTRICAS --}}
        <div class="grid grid-cols-4 gap-3 mb-8">
            <div class="bg-[#8fb3e2ff] border border-stone-100 rounded-xl p-4">
                <p class="text-xs text-white uppercase tracking-wide mb-2">Urgentes</p>
                <p class="text-3xl font-mono font-medium text-red-600">{{ $urgentes }}</p>
            </div>
            <div class="bg-[#8fb3e2ff] border border-stone-100 rounded-xl p-4">
                <p class="text-xs text-white uppercase tracking-wide mb-2">Esta semana</p>
                <p class="text-3xl font-mono font-medium text-amber-600">{{ $estaSemana }}</p>
            </div>
            <div class="bg-[#8fb3e2ff] border border-stone-100 rounded-xl p-4">
                <p class="text-xs text-white uppercase tracking-wide mb-2">Pendientes</p>
                <p class="text-3xl font-mono font-medium text-stone-800">{{ $totalPendientes }}</p>
            </div>
            <div class="bg-[#8fb3e2ff] border border-stone-100 rounded-xl p-4">
                <p class="text-xs text-white uppercase tracking-wide mb-2">Completadas</p>
                <p class="text-3xl font-mono font-medium text-green-700">{{ $completadas }}</p>
            </div>
        </div>

        {{-- TOP TAREAS --}}
        <div class="bg-white border border-stone-100 rounded-xl p-6">
            <p class="text-xs font-medium text-stone-400 uppercase tracking-wide mb-5">
                Enfócate en estas hoy
            </p>

            @forelse($topTareas as $tarea)
            <div class="flex items-start gap-4 py-4 border-b border-stone-50 last:border-0">
                <span class="font-mono text-xs text-stone-300 pt-0.5 w-6">
                    {{ sprintf('%02d', $loop->iteration) }}
                </span>

                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-stone-800">{{ $tarea->title }}</p>
                    <div class="flex flex-wrap gap-3 text-xs text-stone-400 mt-1">
                        <span>{{ $tarea->subject }}</span>
                        @if($tarea->due_date)
                            <span>{{ $tarea->due_date->diffForHumans() }}</span>
                        @endif
                        <span>{{ ucfirst($tarea->tipo) }}</span>
                        <span class="capitalize">{{ $tarea->priority }} prioridad</span>
                    </div>

                    {{-- Barra de urgencia --}}
                    <div class="mt-2 h-0.5 bg-stone-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500
                            @if($tarea->score >= 70) bg-red-400
                            @elseif($tarea->score >= 40) bg-amber-400
                            @else bg-green-400 @endif"
                            style="width: {{ min($tarea->score, 100) }}%">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-end gap-1.5">
                    {{-- Badge de nivel --}}
                    @if($tarea->score >= 70)
                        <span class="text-xs font-medium text-red-700 bg-red-50 px-2 py-0.5 rounded">Urgente</span>
                    @elseif($tarea->score >= 40)
                        <span class="text-xs font-medium text-amber-700 bg-amber-50 px-2 py-0.5 rounded">Próximamente</span>
                    @else
                        <span class="text-xs font-medium text-green-700 bg-green-50 px-2 py-0.5 rounded">Con tiempo</span>
                    @endif
                    <span class="font-mono text-xs text-stone-300">{{ $tarea->score }}</span>
                </div>
            </div>
            @empty
                <p class="text-sm text-stone-400 text-center py-8">Sin tareas pendientes.</p>
            @endforelse
        </div>
    </div>
</div>