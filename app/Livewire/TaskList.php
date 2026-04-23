<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskList extends Component
{
  use WithPagination;

  public string $filtroEstado    = '';
  public string $filtroPrioridad = '';
  public string $filtroMateria   = '';
  public string $busqueda        = '';

  protected $queryString = ['filtroEstado', 'filtroPrioridad', 'filtroMateria'];

  public function updatingBusqueda(): void
  {
    $this->resetPage();
  }
  public function updatingFiltroEstado(): void
  {
    $this->resetPage();
  }

  public function cambiarEstado(int $id, string $nuevoEstado): void
  {
    Task::where('user_id', Auth::id())->findOrFail($id)
      ->update(['status' => $nuevoEstado]);
  }

  public function eliminar(int $id): void
  {
    Task::where('user_id', Auth::id())->findOrFail($id)->delete();
  }

  public function render()
  {
    $tareas = Task::where('user_id', Auth::id())
      ->when($this->filtroEstado,    fn($q) => $q->where('status', $this->filtroEstado))
      ->when($this->filtroPrioridad, fn($q) => $q->where('priority', $this->filtroPrioridad))
      ->when($this->filtroMateria,   fn($q) => $q->where('subject', $this->filtroMateria))
      ->when($this->busqueda,        fn($q) => $q->where('title', 'like', "%{$this->busqueda}%"))
      ->orderByRaw("CASE priority WHEN 'alta' THEN 1 WHEN 'media' THEN 2 ELSE 3 END")
      ->orderBy('due_date')
      ->paginate(10);

    $materias = Task::where('user_id', Auth::id())
      ->whereNotNull('subject')->distinct()->pluck('subject');

    return view('livewire.task-list', compact('tareas', 'materias'))
      ->layout('layouts.app');
  }
}
