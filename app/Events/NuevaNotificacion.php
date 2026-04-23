<?php

namespace App\Events;

use App\Models\Notificacion;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NuevaNotificacion implements ShouldBroadcastNow
{
    public function __construct(public Notificacion $notificacion) {}

    public function broadcastOn(): array
    {
        return [new Channel('notificaciones.' . $this->notificacion->user_id)];
    }

    public function broadcastAs(): string
    {
        return 'nueva.notificacion';
    }
}