<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
  protected $fillable = [
    'user_id',
    'title',
    'subject',
    'description',
    'due_date',
    'priority',
    'status',
    'estimated_minutes',
  ];

  protected $casts = ['due_date' => 'date'];

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
