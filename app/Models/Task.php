<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Task extends Model
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isVencida(): bool
    {
        return $this->due_date
            && $this->due_date->isPast()
            && $this->status !== 'completada';
    }
}