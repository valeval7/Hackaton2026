<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Goal extends Model
{
  protected $fillable = [
    'user_id',
    'title',
    'description',
    'target_date',
    'progress',
    'category',
    'completed',
  ];

  protected $casts = [
    'target_date' => 'date',
    'completed'   => 'boolean',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
