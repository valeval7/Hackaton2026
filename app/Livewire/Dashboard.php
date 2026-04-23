<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tarea;
use App\Services\PriorizacionService;

class Dashboard extends Component
{
    public function mount(PriorizacionService $servicio): void
    {
        $servicio->recalcularTodas(auth()->id());
    }

    public function render()
    {
        $tareas = Tarea::where('user_id', auth()->id())
            ->where('status', '!=', 'completada')
            ->orderBy('score', 'desc')
            ->get();

        return view('livewire.dashboard', [
            'topTareas'       => $tareas->take(3),
            'urgentes'        => $tareas->filter(fn($t) => $t->score >= 70)->count(),
            'estaSemana'      => $tareas->filter(fn($t) =>
                $t->due_date && $t->due_date->diffInDays(now()) <= 7
            )->count(),
            'totalPendientes' => $tareas->count(),
            'completadas'     => Tarea::where('user_id', auth()->id())
                ->where('status', 'completada')->count(),
        ]);
    }
}