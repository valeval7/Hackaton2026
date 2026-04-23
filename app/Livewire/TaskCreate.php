<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskCreate extends Component
{
  public string $title             = '';
  public string $subject           = '';
  public string $description       = '';
  public string $due_date          = '';
  public string $priority          = 'media';
  public ?int   $estimated_minutes = null;

  protected array $rules = [
    'title'             => 'required|string|max:255',
    'subject'           => 'nullable|string|max:100',
    'description'       => 'nullable|string|max:1000',
    'due_date'          => 'nullable|date|after_or_equal:today',
    'priority'          => 'required|in:baja,media,alta',
    'estimated_minutes' => 'nullable|integer|min:5|max:480',
  ];

  protected array $messages = [
    'title.required'          => 'El título es obligatorio.',
    'due_date.after_or_equal' => 'La fecha no puede ser anterior a hoy.',
    'estimated_minutes.max'   => 'Máximo 480 minutos (8 horas).',
  ];

  public function updated(string $field): void
  {
    $this->validateOnly($field);
  }

  public function guardar(): void
  {
    $this->validate();

    Task::create([
      ...$this->only(['title', 'subject', 'description', 'due_date', 'priority', 'estimated_minutes']),
      'user_id' => Auth::id(),
      'status'  => 'pendiente',
    ]);

    session()->flash('mensaje', 'Tarea creada correctamente.');
    $this->redirect(route('tasks.index'), navigate: true);
  }

  public function render()
  {
    return view('livewire.task-create')->layout('layouts.app');
  }
}
