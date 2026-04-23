<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
   protected $table = 'tareas';

    protected $fillable = [
        'user_id',
        'title',
        'subject',
        'description',
        'score',
        'due_date',
        'tipo',
        'priority',
        'status',
        'estimated_minutes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'score' => 'integer',
    ];

    // Relación: una tarea pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope: solo las pendientes
    public function scopePendientes($query)
{
    return $query->where('status', '!=', 'completada');
}

    // Scope: ordenadas por score descendente
    public function scopePorUrgencia($query)
    {
        return $query->orderByDesc('score');
    }
}