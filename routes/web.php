<?php
use App\Livewire\GoalTracker;
use App\Livewire\TaskList;
use App\Livewire\ListaNotificacion;
use App\Livewire\TaskCreate;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/tareas/crear', TaskCreate::class)->name('tasks.create');
    Route::get('/tareas', TaskList::class)->name('tasks.index');
    Route::get('/metas', GoalTracker::class)->name('goals.index');
    Route::get('/notificaciones', ListaNotificacion::class)->name('notifications.index');
});