<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Tarea;
use App\Services\PriorizacionService;

class Dashboard extends Component
{
    // Recalcula scores al montar el componente
    public function mount(PriorizacionService $servicio): void
    {
        $servicio->recalcularTodas(auth()->id());
    }

    public function render()
    {
        $tareas = Tarea::where('user_id', auth()->id())
            ->pendientes()
            ->porUrgencia()
            ->get();

        return view('livewire.dashboard', [
            'topTareas'   => $tareas->take(3),
            'urgentes'    => $tareas->filter(fn($t) => $t->score >= 70)->count(),
            'estaSemana'  => $tareas->filter(fn($t) =>
                                $t->fecha_limite->diffInDays(now()) <= 7
                             )->count(),
            'totalPendientes' => $tareas->count(),
            'completadas' => Tarea::where('user_id', auth()->id())
                                  ->where('completada', true)->count(),
        ]);
    }
}
