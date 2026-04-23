<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;

class ListaNotificacion extends Component
{
    public bool $soloNoLeidas = false;

    #[\Livewire\Attributes\Poll('30s')]
    public function generarRecordatorios(): void
    {
        $tareasProximas = \App\Models\Tarea::where('user_id', Auth::id())
            ->whereDate('fecha_vencimiento', today()->addDay())
            ->where('estado', '!=', 'completada')
            ->get();

        foreach ($tareasProximas as $tarea) {
            Notificacion::firstOrCreate(
                [
                    'user_id'  => Auth::id(),
                    'titulo'   => "Vence mañana: {$tarea->titulo}",
                    'leida'    => false
                ],
                [
                    'tipo'      => 'vencimiento',
                    'contenido' => "La tarea '{$tarea->titulo}' vence mañana."
                ]
            );
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
        $notificaciones = Notificacion::where('user_id', Auth::id())
            ->when($this->soloNoLeidas, fn($q) => $q->where('leida', false))
            ->latest()
            ->paginate(15);

        return view('livewire.lista-notificacion', compact('notificaciones'))
               ->layout('layouts.app');
    }
}