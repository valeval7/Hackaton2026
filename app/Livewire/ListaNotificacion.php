<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Poll;
use App\Models\Notificacion;
use App\Models\Tarea;
use Illuminate\Support\Facades\Auth;

#[Poll('30s')]
class ListaNotificacion extends Component
{
    public bool $soloNoLeidas = false;

    public function mount(): void
    {
        $this->generarRecordatorios();
    }

   private function generarRecordatorios(): void
{
    $tareasProximas = Tarea::where('user_id', Auth::id())
        ->whereDate('due_date', today()->addDay())
        ->where('status', '!=', 'completada')
        ->get();

    foreach ($tareasProximas as $tarea) {
        $notif = Notificacion::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'titulo'  => "Vence mañana: {$tarea->title}",
            ],
            [
                'tipo'      => 'vencimiento',
                'contenido' => "La tarea '{$tarea->title}' vence mañana.",
                'leida'     => false,
            ]
        );

        if ($notif->wasRecentlyCreated) {
            broadcast(new \App\Events\NuevaNotificacion($notif));
        }
    }
}
    public function marcarLeida(int $id): void
    {
        Notificacion::where('user_id', Auth::id())
            ->findOrFail($id)
            ->update(['leida' => true]);
    }

    public function marcarTodasLeidas(): void
    {
        Notificacion::where('user_id', Auth::id())
            ->update(['leida' => true]);
    }

    public function render()
    {
        $this->generarRecordatorios();

        $notificaciones = Notificacion::where('user_id', Auth::id())
            ->when($this->soloNoLeidas, fn($q) => $q->where('leida', false))
            ->latest()
            ->paginate(15);

        return view('livewire.lista-notificacion', compact('notificaciones'))
            ->layout('layouts.app');
    }
}