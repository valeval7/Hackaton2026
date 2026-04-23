<?php
namespace App\Events;

use App\Models\Notificacion;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NuevaNotificacion implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Notificacion $notificacion) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("notificaciones.{$this->notificacion->user_id}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'nueva.notificacion';
    }

    public function broadcastWith(): array
    {
        return [
            'id'       => $this->notificacion->id,
            'titulo'   => $this->notificacion->titulo,
            'contenido'=> $this->notificacion->contenido,
            'tipo'     => $this->notificacion->tipo,
        ];
    }
}