<?php
namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class PopUp extends Component
{
    public int $userId;
    public array $toasts = [];

    public function mount(): void
    {
        $this->userId = Auth::id();
    }

    public function getListeners()
    {
        return [
            "echo-private:notificaciones.{$this->userId},nueva.notificacion" => 'recibirNotificacion',
        ];
    }

    public function recibirNotificacion($event): void
    {
        $this->toasts[] = [
            'id'        => $event['id'] ?? null,
            'titulo'    => $event['titulo'] ?? '',
            'contenido' => $event['contenido'] ?? '',
            'tipo'      => $event['tipo'] ?? 'info',
            'key'       => uniqid(),
        ];

        if (count($this->toasts) > 5) {
            array_shift($this->toasts);
        }
    }

    public function cerrarToast(string $key): void
    {
        $this->toasts = array_values(
            array_filter($this->toasts, fn($t) => $t['key'] !== $key)
        );
    }

    public function render()
    {
        return view('livewire.pop-up')->layout('layouts.app');
    }
}