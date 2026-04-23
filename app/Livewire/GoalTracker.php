<?php

namespace App\Livewire;

use App\Models\Goal;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class GoalTracker extends Component
{
  public bool   $mostrarFormulario = false;
  public string $title             = '';
  public string $description       = '';
  public string $target_date       = '';
  public string $category          = 'academica';

  protected array $rules = [
    'title'       => 'required|string|max:255',
    'description' => 'nullable|string|max:500',
    'target_date' => 'required|date|after:today',
    'category'    => 'required|in:academica,personal,habito',
  ];

  public function guardarMeta(): void
  {
    $this->validate();
    Goal::create([
      ...$this->only(['title', 'description', 'target_date', 'category']),
      'user_id' => Auth::id(),
    ]);
    $this->reset(['title', 'description', 'target_date', 'mostrarFormulario']);
  }

  public function actualizarProgreso(int $id, int $progreso): void
  {
    Goal::where('user_id', Auth::id())->findOrFail($id)->update([
      'progress'  => $progreso,
      'completed' => $progreso >= 100,
    ]);
  }

  public function eliminarMeta(int $id): void
  {
    Goal::where('user_id', Auth::id())->findOrFail($id)->delete();
  }

  public function render()
  {
    $metas = Goal::where('user_id', Auth::id())
      ->orderBy('completed')->orderBy('target_date')->get();

    return view('livewire.goal-tracker', compact('metas'))->layout('layouts.app');
  }
}
