<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $fillable = [
        'user_id', 'nombre', 'materia', 'fecha_limite',
        'peso', 'dificultad', 'tipo', 'notas',
        'completada', 'completada_en', 'score',
    ];

    protected $casts = [
        'fecha_limite'  => 'date',
        'completada'    => 'boolean',
        'completada_en' => 'datetime',
    ];

    // Relación: una tarea pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope: solo las pendientes
    public function scopePendientes($query)
    {
        return $query->where('completada', false);
    }

    // Scope: ordenadas por score descendente
    public function scopePorUrgencia($query)
    {
        return $query->orderByDesc('score');
    }
}